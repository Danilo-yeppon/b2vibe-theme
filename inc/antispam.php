<?php
/**
 * Anti-spam for the Contact Form 7 forms (prenota-una-call / book-a-call).
 *
 * Layers, all evaluated in the `wpcf7_spam` filter so CF7 handles the
 * rejection the usual way (status "spam", no mail sent, spam log entry):
 *  1. Honeypot: a hidden text field that only bots fill in.
 *  2. Time trap: an HMAC-signed timestamp fetched by JS from a non-cached
 *     REST endpoint (the page HTML is cached by LiteSpeed, so the token can't
 *     be printed server-side). Too fast (< 3 s) or too old (> 6 h) = spam.
 *  3. Link limit: more than 2 URLs in the message, or any URL in name/company.
 *  4. Foreign script: Cyrillic / CJK text in an IT/EN form.
 *  5. Rate limit: max 3 submissions per IP every 10 minutes.
 *
 * Thresholds can be tuned with the `b2vibe_antispam_config` filter.
 *
 * @package B2Vibe
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
	exit;
}

const B2VIBE_AS_HONEYPOT = '_b2v_website';
const B2VIBE_AS_TOKEN    = '_b2v_ts';

/**
 * @return array{min_seconds:int,max_age:int,max_links:int,rate_max:int,rate_window:int,max_foreign_chars:int}
 */
function b2vibe_as_config(): array
{
	$defaults = [
		'min_seconds'       => 3,
		'max_age'           => 6 * HOUR_IN_SECONDS,
		'max_links'         => 2,
		'rate_max'          => 3,
		'rate_window'       => 10 * MINUTE_IN_SECONDS,
		'max_foreign_chars' => 3,
	];
	$config = apply_filters('b2vibe_antispam_config', $defaults);
	return is_array($config) ? array_merge($defaults, $config) : $defaults;
}

function b2vibe_as_sign(int $ts): string
{
	return hash_hmac('sha256', 'b2v-form|' . $ts, wp_salt('nonce'));
}

function b2vibe_as_make_token(int $ts): string
{
	return $ts . '.' . b2vibe_as_sign($ts);
}

/**
 * Validate a time-trap token. Returns null when OK, or a reason string.
 */
function b2vibe_as_check_token(string $token, int $now, int $min_seconds, int $max_age): ?string
{
	if ('' === $token) {
		return 'missing token';
	}
	if (! preg_match('/^(\d{9,11})\.([a-f0-9]{64})$/', $token, $m)) {
		return 'malformed token';
	}
	$ts = (int) $m[1];
	if (! hash_equals(b2vibe_as_sign($ts), $m[2])) {
		return 'bad signature';
	}
	$age = $now - $ts;
	if ($age < $min_seconds) {
		return 'too fast (' . $age . 's)';
	}
	if ($age > $max_age) {
		return 'token expired';
	}
	return null;
}

function b2vibe_as_count_links(string $text): int
{
	return (int) preg_match_all('~(?:https?://|www\.)\S+~i', $text);
}

function b2vibe_as_count_foreign_chars(string $text): int
{
	return (int) preg_match_all('/[\p{Cyrillic}\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}]/u', $text);
}

/**
 * Content checks on the posted CF7 fields. Returns null when OK, or a reason.
 *
 * @param array<string,mixed> $posted
 */
function b2vibe_as_check_content(array $posted, int $max_links, int $max_foreign): ?string
{
	$flat = [];
	foreach ($posted as $key => $value) {
		$flat[$key] = is_array($value) ? implode(' ', array_map('strval', $value)) : (string) $value;
	}

	foreach (['your-name', 'your-company'] as $field) {
		if (isset($flat[$field]) && b2vibe_as_count_links($flat[$field]) > 0) {
			return 'link in ' . $field;
		}
	}

	$all = implode("\n", $flat);
	$links = b2vibe_as_count_links($all);
	if ($links > $max_links) {
		return 'too many links (' . $links . ')';
	}

	if (b2vibe_as_count_foreign_chars($all) > $max_foreign) {
		return 'foreign script';
	}

	return null;
}

/**
 * Per-IP rate limit backed by a transient. Returns true when over the limit.
 * Every call counts as one attempt.
 */
function b2vibe_as_rate_limited(string $ip, int $max, int $window): bool
{
	if ('' === $ip) {
		return false;
	}
	$key  = 'b2v_as_rl_' . md5($ip);
	$hits = get_transient($key);
	$hits = is_array($hits) ? $hits : [];
	$now  = time();
	$hits = array_values(array_filter($hits, static fn($t) => is_int($t) && $t > $now - $window));
	$hits[] = $now;
	set_transient($key, $hits, $window);
	return count($hits) > $max;
}

function b2vibe_as_client_ip(): string
{
	// Site is not behind a proxy/CDN, so REMOTE_ADDR is the real client IP.
	$ip = isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
	return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '';
}

/**
 * Main spam decision. Returns null when the submission looks legit.
 *
 * @param array<string,mixed> $request Raw $_POST.
 * @param array<string,mixed> $posted  CF7 posted data (form-tag fields only).
 */
function b2vibe_as_evaluate(array $request, array $posted, string $ip, int $now): ?string
{
	$c = b2vibe_as_config();

	$honeypot = isset($request[B2VIBE_AS_HONEYPOT]) ? trim((string) $request[B2VIBE_AS_HONEYPOT]) : '';
	if ('' !== $honeypot) {
		return 'honeypot filled';
	}

	$token  = isset($request[B2VIBE_AS_TOKEN]) ? trim((string) $request[B2VIBE_AS_TOKEN]) : '';
	$reason = b2vibe_as_check_token($token, $now, (int) $c['min_seconds'], (int) $c['max_age']);
	if (null !== $reason) {
		return $reason;
	}

	$reason = b2vibe_as_check_content($posted, (int) $c['max_links'], (int) $c['max_foreign_chars']);
	if (null !== $reason) {
		return $reason;
	}

	if (b2vibe_as_rate_limited($ip, (int) $c['rate_max'], (int) $c['rate_window'])) {
		return 'rate limited';
	}

	return null;
}

/**
 * CF7 hook: mark as spam (CF7 then discards it silently, no mail sent).
 *
 * @param bool  $spam
 * @param mixed $submission WPCF7_Submission
 */
function b2vibe_as_wpcf7_spam($spam, $submission = null)
{
	if ($spam || ! is_object($submission) || ! method_exists($submission, 'get_posted_data')) {
		return $spam;
	}

	$request = wp_unslash($_POST); // phpcs:ignore WordPress.Security.NonceVerification
	$reason  = b2vibe_as_evaluate(
		is_array($request) ? $request : [],
		(array) $submission->get_posted_data(),
		b2vibe_as_client_ip(),
		time()
	);

	if (null === $reason) {
		return false;
	}

	if (method_exists($submission, 'add_spam_log')) {
		$submission->add_spam_log([
			'agent'  => 'b2vibe-antispam',
			'reason' => $reason,
		]);
	}
	return true;
}
add_filter('wpcf7_spam', 'b2vibe_as_wpcf7_spam', 20, 2);

/**
 * Add honeypot + token field to every CF7 form (static markup, cache-safe).
 */
function b2vibe_as_form_elements(string $html): string
{
	$fields = '<span class="b2v-hp" aria-hidden="true" style="position:absolute!important;left:-9999px!important;width:1px;height:1px;overflow:hidden">'
		. '<label>Website<input type="text" name="' . B2VIBE_AS_HONEYPOT . '" value="" tabindex="-1" autocomplete="off"></label>'
		. '</span>'
		. '<input type="hidden" name="' . B2VIBE_AS_TOKEN . '" value="" class="b2v-ts">';
	return $fields . $html;
}
add_filter('wpcf7_form_elements', 'b2vibe_as_form_elements');

/**
 * GET /wp-json/b2vibe/v1/form-token — fresh signed timestamp, never cached.
 */
add_action('rest_api_init', function (): void {
	register_rest_route('b2vibe/v1', '/form-token', [
		'methods'             => 'GET',
		'permission_callback' => '__return_true',
		'callback'            => static function () {
			do_action('litespeed_control_set_nocache', 'b2vibe form token');
			$response = new WP_REST_Response(['token' => b2vibe_as_make_token(time())]);
			$response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
			$response->header('X-LiteSpeed-Cache-Control', 'no-cache');
			return $response;
		},
	]);
});

/**
 * Load the token script only on the pages that have the form.
 */
function b2vibe_as_enqueue(): void
{
	if (! is_page(['prenota-una-call', 'book-a-call'])) {
		return;
	}
	wp_enqueue_script(
		'b2vibe-antispam',
		get_template_directory_uri() . '/assets/js/antispam.js',
		[],
		b2vibe_asset_ver('assets/js/antispam.js'),
		true
	);
	wp_add_inline_script(
		'b2vibe-antispam',
		'window.b2vAntispam=' . wp_json_encode(['endpoint' => esc_url_raw(rest_url('b2vibe/v1/form-token'))]) . ';',
		'before'
	);
}
add_action('wp_enqueue_scripts', 'b2vibe_as_enqueue', 30);
