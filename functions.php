<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
	exit;
}

define('B2VIBE_VERSION', '1.7.1');

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
		get_template_directory_uri() . '/assets/fonts/raleway.css',
		[],
		B2VIBE_VERSION
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

	if (is_front_page()) {
		wp_enqueue_script(
			'b2vibe-scramble',
			get_template_directory_uri() . '/assets/js/scramble.js',
			[],
			B2VIBE_VERSION,
			true
		);
	}

	add_action('wp_head', function () {
		echo '<script id="warmly-script-loader" data-no-optimize="1" data-no-defer="1" src="https://opps-widget.getwarmly.com/warmly.js?clientId=f360013ba4c91a52988319241b9cd5ef" defer></script>' . "\n";
	}, 99);

	add_action('wp_head', function () {
		echo '<script async data-no-optimize="1" src="https://www.googletagmanager.com/gtag/js?id=G-V4XBRN2PM5"></script>' . "\n";
		echo '<script data-no-optimize="1">window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-V4XBRN2PM5");</script>' . "\n";
	}, 2);

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
 * Performance: Preload self-hosted Raleway latin font (critical for FCP).
 */
function b2vibe_preload_fonts(): void
{
	echo '<link rel="preload" href="' . esc_url(get_template_directory_uri() . '/assets/fonts/raleway-latin.woff2') . '" as="font" type="font/woff2" crossorigin>' . "\n";
}
add_action('wp_head', 'b2vibe_preload_fonts', 1);

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
	$theme = get_stylesheet();

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

	$corrected = trailingslashit($remote_source) . get_stylesheet() . '/';
	if ($source !== $corrected && is_dir($source)) {
		if (! rename($source, $corrected)) {
			return $source;
		}
	}

	return $corrected;
}
add_filter('upgrader_source_selection', 'b2vibe_upgrader_source', 10, 3);

/**
 * JSON-LD Structured Data — outputs schema.org markup in <head>.
 */
function b2vibe_jsonld(): void
{
	$schema = [];

	// WebSite schema (all pages)
	$schema[] = [
		'@type'           => 'WebSite',
		'@id'             => home_url('/#website'),
		'url'             => home_url('/'),
		'name'            => 'B2Vibe',
		'description'     => 'E-commerce Full Outsourcing & Merchant of Record',
		'inLanguage'      => 'it-IT',
		'publisher'       => ['@id' => home_url('/#organization')],
	];

	// Organization (all pages)
	$schema[] = [
		'@type'       => 'Organization',
		'@id'         => home_url('/#organization'),
		'name'        => 'B2VIBE S.r.l.',
		'url'         => home_url('/'),
		'logo'        => [
			'@type'  => 'ImageObject',
			'url'    => get_template_directory_uri() . '/assets/img/logo-b2vibe.png',
			'width'  => 160,
			'height' => 24,
		],
		'description' => 'E-commerce Full Outsourcing & Merchant of Record. Gestiamo la complessità per far crescere il tuo brand sui marketplace europei.',
		'email'       => 'info@b2vibe.com',
		'address'     => [
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Via Santi 11/13',
			'addressLocality' => 'Paderno Dugnano',
			'addressRegion'   => 'MI',
			'postalCode'      => '20037',
			'addressCountry'  => 'IT',
		],
		'legalName'       => 'B2VIBE S.r.l.',
		'vatID'           => 'IT14234560960',
		'foundingDate'    => '2022',
		'numberOfEmployees' => [
			'@type' => 'QuantitativeValue',
			'minValue' => 10,
			'maxValue' => 50,
		],
		'sameAs' => [
				'https://www.linkedin.com/company/b2vibe',
				'https://www.instagram.com/b2.vibe/',
			],
		'knowsAbout' => [
			'E-commerce outsourcing',
			'Merchant of Record',
			'Marketplace management',
			'Amazon seller management',
			'Cross-border e-commerce',
			'Logistica e-commerce',
			'Customer care multilingua',
		],
	];

	// Front page: LocalBusiness + Service offerings
	if (is_front_page()) {
		$schema[] = [
			'@type'          => 'LocalBusiness',
			'@id'            => home_url('/#localbusiness'),
			'name'           => 'B2VIBE S.r.l.',
			'image'          => get_template_directory_uri() . '/assets/img/logo-b2vibe.png',
			'url'            => home_url('/'),
			'telephone'      => '',
			'email'          => 'info@b2vibe.com',
			'address'        => [
				'@type'           => 'PostalAddress',
				'streetAddress'   => 'Via Santi 11/13',
				'addressLocality' => 'Paderno Dugnano',
				'addressRegion'   => 'MI',
				'postalCode'      => '20037',
				'addressCountry'  => 'IT',
			],
			'priceRange'     => '€€€',
			'areaServed'     => [
				'@type' => 'GeoCircle',
				'geoMidpoint' => [
					'@type'     => 'GeoCoordinates',
					'latitude'  => 45.52,
					'longitude' => 9.17,
				],
				'geoRadius' => '2000000',
			],
			'hasOfferCatalog' => [
				'@type'           => 'OfferCatalog',
				'name'            => 'Servizi B2Vibe',
				'itemListElement' => [
					[
						'@type' => 'OfferCatalog',
						'name'  => 'Ecommerce Management',
						'url'   => home_url('/ecommerce-management/'),
					],
					[
						'@type' => 'OfferCatalog',
						'name'  => 'Merchant of Record',
						'url'   => home_url('/merchant-of-record/'),
					],
					[
						'@type' => 'OfferCatalog',
						'name'  => 'Logistica e Magazzino',
						'url'   => home_url('/logistica-e-magazzino/'),
					],
					[
						'@type' => 'OfferCatalog',
						'name'  => 'Customer Care',
						'url'   => home_url('/customer-care/'),
					],
				],
			],
		];
	}

	// Service pages (template: page-servizio.php)
	if (is_page() && get_page_template_slug() === 'page-servizio.php') {
		$schema[] = [
			'@type'       => 'Service',
			'@id'         => get_permalink() . '#service',
			'name'        => get_the_title(),
			'description' => get_post_meta(get_the_ID(), 'b2v_service_intro', true) ?: wp_strip_all_tags(get_the_excerpt()),
			'url'         => get_permalink(),
			'provider'    => ['@id' => home_url('/#organization')],
			'areaServed'  => [
				'@type' => 'Place',
				'name'  => 'Europa',
			],
			'serviceType' => get_the_title(),
		];
	}

	// Single blog posts: Article
	if (is_singular('post')) {
		$thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
		$schema[] = [
			'@type'            => 'Article',
			'@id'              => get_permalink() . '#article',
			'headline'         => get_the_title(),
			'description'      => wp_strip_all_tags(get_the_excerpt()),
			'url'              => get_permalink(),
			'datePublished'    => get_the_date('c'),
			'dateModified'     => get_the_modified_date('c'),
			'mainEntityOfPage' => get_permalink(),
			'image'            => $thumb ?: '',
			'author'           => [
				'@type' => 'Organization',
				'name'  => 'B2Vibe',
				'url'   => home_url('/'),
			],
			'publisher'        => ['@id' => home_url('/#organization')],
			'inLanguage'       => 'it-IT',
		];
	}

	// Blog archive: CollectionPage
	if (is_home() || is_archive()) {
		$schema[] = [
			'@type'       => 'CollectionPage',
			'@id'         => get_pagenum_link(1) . '#collection',
			'name'        => is_category() ? single_cat_title('', false) : 'Blog B2Vibe',
			'description' => 'Articoli e approfondimenti su e-commerce, marketplace e logistica.',
			'url'         => get_pagenum_link(1),
			'isPartOf'    => ['@id' => home_url('/#website')],
		];
	}

	// BreadcrumbList (all pages except front page)
	if (! is_front_page()) {
		$crumbs = [
			['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => home_url('/')],
		];
		$pos = 2;

		if (is_singular('post')) {
			$crumbs[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => 'Blog', 'item' => get_permalink(get_option('page_for_posts'))];
			$crumbs[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => get_the_title()];
		} elseif (is_home()) {
			$crumbs[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => 'Blog'];
		} elseif (is_page()) {
			$crumbs[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => get_the_title()];
		}

		$schema[] = [
			'@type'           => 'BreadcrumbList',
			'@id'             => get_permalink() . '#breadcrumb',
			'itemListElement' => $crumbs,
		];
	}

	// Output
	$output = [
		'@context' => 'https://schema.org',
		'@graph'   => $schema,
	];

	echo '<script type="application/ld+json">' . wp_json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
}
add_action('wp_head', 'b2vibe_jsonld', 5);

/**
 * Serve llms.txt and llms-full.txt from theme directory.
 */
function b2vibe_llms_txt(): void
{
	$request = $_SERVER['REQUEST_URI'] ?? '';

	if ($request === '/llms.txt' || $request === '/llms-full.txt') {
		$file = get_template_directory() . '/' . basename($request);
		if (file_exists($file)) {
			header('Content-Type: text/plain; charset=utf-8');
			header('X-Robots-Tag: noindex');
			readfile($file);
			exit;
		}
	}
}
add_action('template_redirect', 'b2vibe_llms_txt', 1);

/**
 * Serve manifest.json for PWA / Web App.
 */
function b2vibe_manifest(): void
{
	if (($_SERVER['REQUEST_URI'] ?? '') !== '/manifest.json') {
		return;
	}

	$dir = get_template_directory_uri();
	$img = file_exists(get_template_directory() . '/assets/img/icon-192.png') ? $dir . '/assets/img' : content_url('/uploads/2026/05');

	header('Content-Type: application/manifest+json');
	echo wp_json_encode([
		'name'             => 'B2Vibe - E-commerce Outsourcing',
		'short_name'       => 'B2Vibe',
		'description'      => 'E-commerce Full Outsourcing & Merchant of Record',
		'start_url'        => '/',
		'display'          => 'standalone',
		'background_color' => '#0a1628',
		'theme_color'      => '#0a1628',
		'icons'            => [
			['src' => $img . '/icon-192.png', 'sizes' => '192x192', 'type' => 'image/png'],
			['src' => $img . '/icon-512.png', 'sizes' => '512x512', 'type' => 'image/png'],
		],
	], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
	exit;
}
add_action('template_redirect', 'b2vibe_manifest', 1);

/**
 * Security: Send hardening HTTP headers on every front-end response.
 */
function b2vibe_security_headers(): void
{
	if (is_admin()) {
		return;
	}

	header('X-Content-Type-Options: nosniff');
	header('X-Frame-Options: SAMEORIGIN');
	header('Referrer-Policy: strict-origin-when-cross-origin');
	header('Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(), usb=()');
	if (is_ssl()) {
		header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
	}
}
add_action('send_headers', 'b2vibe_security_headers');

/**
 * Favicon, Apple Touch Icon & Web App Manifest.
 */
function b2vibe_favicon(): void
{
	$dir = get_template_directory_uri();
	// Check theme dir first, fall back to uploads
	$img = file_exists(get_template_directory() . '/assets/img/favicon-32.png') ? $dir . '/assets/img' : content_url('/uploads/2026/05');
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url($img . '/favicon-32.png') . '">' . "\n";
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url($img . '/apple-touch-icon.png') . '">' . "\n";
	echo '<link rel="manifest" href="' . esc_url(home_url('/manifest.json')) . '">' . "\n";
	echo '<meta name="theme-color" content="#0a1628">' . "\n";
}
add_action('wp_head', 'b2vibe_favicon', 2);

/**
 * IndexNow: instant search-engine indexing on publish/update.
 *
 * – Generates a random API key on first run and stores it in the DB.
 * – Serves the key-verification file at /{key}.txt automatically.
 * – Pings IndexNow (Bing/Yandex/Naver/Seznam) whenever a post or page
 *   transitions to "publish" or is updated while published.
 */
function b2vibe_indexnow_key(): string
{
    $key = get_option('b2vibe_indexnow_key');
    if (! $key) {
        $key = wp_generate_uuid4();
        $key = str_replace('-', '', $key);          // 32-char hex
        update_option('b2vibe_indexnow_key', $key, true);
    }
    return $key;
}

/* Serve the verification file: /[key].txt → the key itself. */
function b2vibe_indexnow_verification(): void
{
    $uri = trim($_SERVER['REQUEST_URI'] ?? '', '/');
    $key = b2vibe_indexnow_key();
    if ($uri === $key . '.txt') {
        header('Content-Type: text/plain; charset=utf-8');
        echo $key;
        exit;
    }
}
add_action('template_redirect', 'b2vibe_indexnow_verification', 0);

/* Ping IndexNow on publish/update. */
function b2vibe_indexnow_ping(string $new_status, string $old_status, \WP_Post $post): void
{
    if ($new_status !== 'publish') {
        return;
    }
    if (! in_array($post->post_type, ['post', 'page'], true)) {
        return;
    }

    $key = b2vibe_indexnow_key();
    $url = get_permalink($post);
    if (! $url) {
        return;
    }

    $endpoint = 'https://api.indexnow.org/indexnow';
    $body     = wp_json_encode([
        'host'    => wp_parse_url(home_url(), PHP_URL_HOST),
        'key'     => $key,
        'keyLocation' => home_url('/' . $key . '.txt'),
        'urlList' => [$url],
    ]);

    wp_remote_post($endpoint, [
        'body'      => $body,
        'headers'   => ['Content-Type' => 'application/json; charset=utf-8'],
        'timeout'   => 5,
        'blocking'  => false,   // fire-and-forget
        'sslverify' => true,
    ]);
}
add_action('transition_post_status', 'b2vibe_indexnow_ping', 10, 3);

/**
 * Disable Yoast SEO JSON-LD schema output to avoid duplicate structured data.
 * The theme outputs its own, more detailed schema via b2vibe_jsonld().
 */
add_filter('wpseo_json_ld_output', '__return_false');
