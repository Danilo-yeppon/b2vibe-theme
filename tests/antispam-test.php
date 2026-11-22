<?php
/**
 * Logic tests for inc/antispam.php with minimal WordPress stubs.
 * Run: php tests/antispam-test.php
 */
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
	exit;
}

define('ABSPATH', __DIR__ . '/');
define('MINUTE_IN_SECONDS', 60);
define('HOUR_IN_SECONDS', 3600);

$GLOBALS['__filters'] = [];
$GLOBALS['__transients'] = [];
function add_filter($h, $cb, $p = 10, $a = 1) { $GLOBALS['__filters'][$h][] = $cb; return true; }
function add_action($h, $cb, $p = 10, $a = 1) { return add_filter($h, $cb, $p, $a); }
function apply_filters($h, $v) { return $v; }
function wp_salt($s = '') { return 'test-salt'; }
function get_transient($k) { return $GLOBALS['__transients'][$k] ?? false; }
function set_transient($k, $v, $t) { $GLOBALS['__transients'][$k] = $v; return true; }
function wp_unslash($v) { return $v; }

require __DIR__ . '/../inc/antispam.php';

$fail = 0;
function check(string $name, $got, $want): void {
	global $fail;
	$ok = $got === $want;
	if (! $ok) { $fail++; }
	echo ($ok ? 'PASS ' : 'FAIL ') . $name . ($ok ? '' : ' got=' . var_export($got, true) . ' want=' . var_export($want, true)) . "\n";
}

$now   = 1_800_000_000;
$good  = ['your-name' => 'Mario Rossi', 'your-company' => 'Acme Srl', 'your-message' => 'Vorrei vendere su Amazon, vedi https://acme.it'];
$token = b2vibe_as_make_token($now - 30);
$req   = ['_b2v_ts' => $token, '_b2v_website' => ''];

check('legit passes', b2vibe_as_evaluate($req, $good, '1.1.1.1', $now), null);
check('honeypot', b2vibe_as_evaluate(['_b2v_website' => 'x'] + $req, $good, '1.1.1.2', $now), 'honeypot filled');
check('missing token', b2vibe_as_evaluate(['_b2v_website' => ''], $good, '1.1.1.3', $now), 'missing token');
check('malformed token', b2vibe_as_evaluate(['_b2v_ts' => 'abc'], $good, '1.1.1.3', $now), 'malformed token');
$forged = ($now - 30) . '.' . str_repeat('a', 64);
check('forged signature', b2vibe_as_evaluate(['_b2v_ts' => $forged], $good, '1.1.1.3', $now), 'bad signature');
check('too fast', b2vibe_as_evaluate(['_b2v_ts' => b2vibe_as_make_token($now - 1)], $good, '1.1.1.3', $now), 'too fast (1s)');
check('3s ok', b2vibe_as_evaluate(['_b2v_ts' => b2vibe_as_make_token($now - 3)], $good, '1.1.1.4', $now), null);
check('expired', b2vibe_as_evaluate(['_b2v_ts' => b2vibe_as_make_token($now - 7 * 3600)], $good, '1.1.1.3', $now), 'token expired');
check('3 links', b2vibe_as_evaluate($req, ['your-message' => 'http://a.com http://b.com www.c.com'] + $good, '1.1.1.5', $now), 'too many links (3)');
check('2 links ok', b2vibe_as_evaluate($req, ['your-message' => 'http://a.com e www.c.com'] + $good, '1.1.1.6', $now), null);
check('link in name', b2vibe_as_evaluate($req, ['your-name' => 'Buy http://spam.ru'] + $good, '1.1.1.7', $now), 'link in your-name');
check('cyrillic', b2vibe_as_evaluate($req, ['your-message' => 'Здравствуйте, предлагаем услуги'] + $good, '1.1.1.8', $now), 'foreign script');
check('chinese', b2vibe_as_evaluate($req, ['your-message' => '我们提供优质服务'] + $good, '1.1.1.8', $now), 'foreign script');
check('accents ok', b2vibe_as_evaluate($req, ['your-message' => 'Perché è già così? Ça va, Müller'] + $good, '1.1.1.9', $now), null);

$ip = '9.9.9.9';
$r = [];
for ($i = 0; $i < 4; $i++) { $r[] = b2vibe_as_evaluate($req, $good, $ip, $now); }
check('rate limit: 3 ok then blocked', $r, [null, null, null, 'rate limited']);
check('other IP unaffected', b2vibe_as_evaluate($req, $good, '8.8.8.8', $now), null);

// Filter wiring + spam log.
class FakeSubmission {
	public array $log = [];
	public function __construct(private array $data) {}
	public function get_posted_data(): array { return $this->data; }
	public function add_spam_log($d): void { $this->log[] = $d; }
}
$_SERVER['REMOTE_ADDR'] = '7.7.7.7';
$_POST = ['_b2v_ts' => '', '_b2v_website' => ''];
$sub = new FakeSubmission($good);
check('wpcf7_spam marks spam', b2vibe_as_wpcf7_spam(false, $sub), true);
check('spam log reason', $sub->log[0]['reason'] ?? null, 'missing token');
check('already spam stays spam', b2vibe_as_wpcf7_spam(true, $sub), true);
$_POST = ['_b2v_ts' => b2vibe_as_make_token(time() - 30), '_b2v_website' => ''];
check('wpcf7_spam legit', b2vibe_as_wpcf7_spam(false, new FakeSubmission($good)), false);
check('hooks registered', isset($GLOBALS['__filters']['wpcf7_spam'], $GLOBALS['__filters']['wpcf7_form_elements']), true);
$html = b2vibe_as_form_elements('<p>x</p>');
check('honeypot markup', str_contains($html, 'name="_b2v_website"') && str_contains($html, 'tabindex="-1"') && str_contains($html, 'aria-hidden="true"') && str_contains($html, 'autocomplete="off"'), true);

echo $fail ? "\n$fail FAILED\n" : "\nALL PASSED\n";
exit($fail ? 1 : 0);
