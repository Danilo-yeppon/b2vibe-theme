<?php
/**
 * Single post template.
 *
 * @package B2Vibe
 */

declare(strict_types=1);

get_header();
?>

<main class="b2v-content">
	<div class="b2v-container b2v-content--narrow">
		<?php while (have_posts()) : the_post(); ?>
			<span class="b2v-label"><?php echo esc_html(get_the_date()); ?></span>
			<h1><?php the_title(); ?></h1>

			<?php if (has_post_thumbnail()) : ?>
				<figure class="b2v-content__featured">
					<?php the_post_thumbnail('large', ['loading' => 'lazy', 'decoding' => 'async']); ?>
				</figure>
			<?php endif; ?>

			<div class="b2v-content__body">
				<?php the_content(); ?>
			</div>

			<?php
			$service_slugs = ['customer-care', 'ecommerce-management', 'logistica-e-magazzino', 'merchant-of-record'];
			$categories    = get_the_category();
			$service_slug  = ($categories[0]->slug ?? '');
			if (in_array($service_slug, $service_slugs, true)) {
				$service_page = get_page_by_path($service_slug);
				if ($service_page instanceof WP_Post) {
					$service_id = (int) $service_page->ID;
					if (function_exists('pll_current_language') && function_exists('pll_get_post')) {
						$translated = pll_get_post($service_id, pll_current_language());
						if ($translated) {
							$service_id = (int) $translated;
						}
					}
					$service_title = get_the_title($service_id);
					?>
			<aside class="b2v-card b2v-service-box">
				<span class="b2v-label"><?php esc_html_e('Servizio correlato', 'b2vibe'); ?></span>
				<h2><?php echo esc_html($service_title); ?></h2>
				<p><?php printf(esc_html__('Scopri come lavoriamo su %s.', 'b2vibe'), esc_html($service_title)); ?></p>
				<a href="<?php echo esc_url(b2vibe_link('/' . $service_slug . '/')); ?>" class="b2v-btn b2v-btn--outline">
					<?php esc_html_e('Scopri il servizio', 'b2vibe'); ?>
				</a>
			</aside>
					<?php
				}
			}
			?>

			<?php
			the_post_navigation([
				'prev_text' => '<span class="b2v-label">' . esc_html__('Precedente', 'b2vibe') . '</span> %title',
				'next_text' => '<span class="b2v-label">' . esc_html__('Successivo', 'b2vibe') . '</span> %title',
			]);
			?>
		<?php endwhile; ?>
	</div>
</main>

<?php get_footer(); ?>
