<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="b2v-header" role="banner">
	<div class="b2v-container b2v-header__inner">
		<a href="<?php echo esc_url(home_url('/')); ?>" class="b2v-logo" rel="home">
			<?php if (has_custom_logo()) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<img
					src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo-b2vibe.png'); ?>"
					alt="B2Vibe"
					class="b2v-logo__img"
					width="160"
					height="24"
				>
			<?php endif; ?>
		</a>

		<button class="b2v-nav-toggle" aria-label="<?php esc_attr_e('Toggle menu', 'b2vibe'); ?>" aria-expanded="false">
			<span></span><span></span><span></span>
		</button>

		<?php if (has_nav_menu('primary')) : ?>
			<?php wp_nav_menu([
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'b2v-nav',
				'items_wrap'     => '<nav id="%1$s" class="%2$s" role="navigation" aria-label="' . esc_attr__('Primary', 'b2vibe') . '">%3$s</nav>',
				'depth'          => 1,
			]); ?>
		<?php else : ?>
			<nav class="b2v-nav" role="navigation" aria-label="<?php esc_attr_e('Primary', 'b2vibe'); ?>">
				<a href="<?php echo esc_url(home_url('/#chi-siamo')); ?>"><?php esc_html_e('Chi siamo', 'b2vibe'); ?></a>
				<a href="<?php echo esc_url(home_url('/#servizi')); ?>"><?php esc_html_e('Servizi', 'b2vibe'); ?></a>
				<a href="<?php echo esc_url(home_url('/#vantaggi')); ?>"><?php esc_html_e('Vantaggi', 'b2vibe'); ?></a>
				<a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('Blog', 'b2vibe'); ?></a>
			</nav>
		<?php endif; ?>

		<div class="b2v-header__cta">
			<a href="<?php echo esc_url(home_url('/prenota-una-call/')); ?>" class="b2v-btn b2v-btn--primary">
				<?php esc_html_e('Prenota una call', 'b2vibe'); ?>
			</a>
		</div>
	</div>
</header>
