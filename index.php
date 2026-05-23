<?php
/**
 * Main fallback template.
 *
 * @package B2Vibe
 */

declare(strict_types=1);

get_header();
?>

<main class="b2v-section">
	<div class="b2v-container">
		<?php if (have_posts()) : ?>
			<div class="b2v-archive-grid">
				<?php while (have_posts()) : the_post(); ?>
					<article class="b2v-post-card">
						<?php if (has_post_thumbnail()) : ?>
							<a href="<?php the_permalink(); ?>" class="b2v-post-card__thumb" aria-hidden="true">
								<?php the_post_thumbnail('medium_large', ['loading' => 'lazy', 'decoding' => 'async']); ?>
							</a>
						<?php endif; ?>
						<div class="b2v-post-card__body">
							<h3 class="b2v-post-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<p class="b2v-post-card__excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e('Nessun contenuto trovato.', 'b2vibe'); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
