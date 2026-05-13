<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
	exit;
}

define('B2VIBE_VERSION', '1.0.0');

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
}
add_action('wp_enqueue_scripts', 'b2vibe_enqueue_assets');

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
