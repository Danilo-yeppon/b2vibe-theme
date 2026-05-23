<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
	exit;
}

define('B2VIBE_VERSION', '1.2.1');

function b2vibe_setup(): void
{
	load_theme_textdomain('b2vibe', get_template_directory() . '/languages');

	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	]);
	add_theme_support('custom-logo', [
		'height'      => 40,
		'width'       => 180,
		'flex-height' => true,
		'flex-width'  => true,
	]);
	add_theme_support('automatic-feed-links');

	register_nav_menus([
		'primary' => esc_html__('Primary Menu', 'b2vibe'),
		'footer'  => esc_html__('Footer Menu', 'b2vibe'),
	]);

	set_post_thumbnail_size(800, 450, true);
}
add_action('after_setup_theme', 'b2vibe_setup');

function b2vibe_enqueue_assets(): void
{
	wp_deregister_script('jquery');

	wp_enqueue_style(
		'b2vibe-fonts',
		'https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800;900&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'b2vibe-style',
		get_stylesheet_uri(),
		['b2vibe-fonts'],
		B2VIBE_VERSION
	);

	if (is_front_page()) {
		wp_enqueue_style(
			'b2vibe-front',
			get_template_directory_uri() . '/front-page.css',
			['b2vibe-style'],
			B2VIBE_VERSION
		);
	}

	wp_enqueue_script(
		'b2vibe-nav',
		get_template_directory_uri() . '/assets/js/nav.js',
		[],
		B2VIBE_VERSION,
		true
	);

	// Load CF7 assets only on the contact page
	if (! is_page('prenota-una-call')) {
		wp_dequeue_style('contact-form-7');
		wp_dequeue_script('contact-form-7');
		wp_dequeue_script('wpcf7-recaptcha');
		wp_dequeue_script('google-recaptcha');
	}
}
add_action('wp_enqueue_scripts', 'b2vibe_enqueue_assets', 20);

/**
 * Performance: Remove WordPress emoji scripts & styles (saves ~15 KB).
 */
function b2vibe_disable_emojis(): void
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', static function (array $plugins): array {
		return array_diff($plugins, ['wpemoji']);
	});
	add_filter('wp_resource_hints', static function (array $urls, string $relation): array {
		if ($relation === 'dns-prefetch') {
			$urls = array_filter($urls, static fn($url) => ! str_contains((string) $url, 'twemoji'));
		}
		return $urls;
	}, 10, 2);
}
add_action('init', 'b2vibe_disable_emojis');

/**
 * Performance: Remove Gutenberg block CSS on front-end (saves ~30 KB).
 */
function b2vibe_remove_block_css(): void
{
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-blocks-style');
	wp_dequeue_style('global-styles');
	wp_dequeue_style('global-styles-inline');
	wp_dequeue_style('classic-theme-styles');
	wp_dequeue_style('core-block-supports');
}
add_action('wp_enqueue_scripts', 'b2vibe_remove_block_css', 100);

/**
 * Performance: Remove WP global styles and SVG filters (saves ~8 KB inline CSS).
 */
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

/**
 * Performance: Add preconnect for Google Fonts & swap dns-prefetch.
 */
function b2vibe_resource_hints(): void
{
	echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'b2vibe_resource_hints', 1);

/**
 * Performance: Remove WP version meta, shortlink, REST link, oEmbed, RSD, wlwmanifest.
 */
function b2vibe_clean_head(): void
{
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wp_shortlink_wp_head');
	remove_action('wp_head', 'rest_output_link_wp_head');
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
}
add_action('after_setup_theme', 'b2vibe_clean_head');

/**
 * Performance: Remove DNS prefetch for WordPress.org (s.w.org).
 */
add_filter('emoji_svg_url', '__return_false');

function b2vibe_nav_menu_css_class(array $classes): array
{
	return array_filter($classes, static fn(string $c): bool =>
		in_array($c, ['current-menu-item', 'menu-item-has-children', 'current-menu-ancestor'], true)
	);
}
add_filter('nav_menu_css_class', 'b2vibe_nav_menu_css_class');

function b2vibe_nav_menu_item_id(): string
{
	return '';
}
add_filter('nav_menu_item_id', 'b2vibe_nav_menu_item_id');

function b2vibe_excerpt_length(): int
{
	return 20;
}
add_filter('excerpt_length', 'b2vibe_excerpt_length');

function b2vibe_excerpt_more(): string
{
	return '&hellip;';
}
add_filter('excerpt_more', 'b2vibe_excerpt_more');

function b2vibe_register_meta(): void
{
	$meta_keys = ['b2v_service_label', 'b2v_service_intro', 'b2v_service_features', 'b2v_service_benefits'];
	foreach ($meta_keys as $key) {
		register_post_meta('page', $key, [
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => static fn(): bool => current_user_can('edit_posts'),
		]);
	}
}
add_action('init', 'b2vibe_register_meta');

/**
 * GitHub Theme Updater — checks for new versions on GitHub
 */
function b2vibe_github_updater($transient)
{
	if (! is_object($transient)) {
		return $transient;
	}

	if (empty($transient->checked)) {
		return $transient;
	}

	$repo  = 'Danilo-yeppon/b2vibe-theme';
	$theme = 'b2vibe';

	$response = wp_remote_get("https://api.github.com/repos/{$repo}/releases/latest", [
		'headers' => ['Accept' => 'application/vnd.github.v3+json'],
		'timeout' => 10,
	]);

	if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
		return $transient;
	}

	$release = json_decode(wp_remote_retrieve_body($response), true);
	if (empty($release['tag_name'])) {
		return $transient;
	}

	$new_version = ltrim($release['tag_name'], 'v');
	$current     = $transient->checked[$theme] ?? B2VIBE_VERSION;

	if (version_compare($new_version, $current, '>')) {
		$transient->response[$theme] = [
			'theme'       => $theme,
			'new_version' => $new_version,
			'url'         => "https://github.com/{$repo}",
			'package'     => $release['zipball_url'] ?? "https://api.github.com/repos/{$repo}/zipball/{$release['tag_name']}",
		];
	}

	return $transient;
}
add_filter('site_transient_update_themes', 'b2vibe_github_updater');

/**
 * Fix GitHub ZIP folder name (removes commit hash suffix)
 */
function b2vibe_upgrader_source(string $source, string $remote_source, $upgrader): string
{
	if (! isset($upgrader->skin) || ! is_object($upgrader->skin)) {
		return $source;
	}

	$theme_info = $upgrader->skin->theme_info ?? null;
	if (! $theme_info || ! is_object($theme_info) || $theme_info->get('Name') !== 'B2Vibe') {
		return $source;
	}

	$corrected = trailingslashit($remote_source) . 'b2vibe/';
	if ($source !== $corrected && is_dir($source)) {
		rename($source, $corrected);
	}

	return $corrected;
}
add_filter('upgrader_source_selection', 'b2vibe_upgrader_source', 10, 3);
