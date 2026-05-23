<?php
/**
 * Archive template.
 *
 * @package B2Vibe
 */

declare(strict_types=1);

get_header();
?>

<main class="b2v-content">
	<div class="b2v-container">
		<header class="b2v-content--narrow" style="margin-bottom: 48px;">
			<span class="b2v-label"><?php esc_html_e('Blog', 'b2vibe'); ?></span>
			<?php the_archive_title('<h1>', '</h1>'); ?>
			<?php the_archive_description('<p class="b2v-text-muted">', '</p>'); ?>
		</header>

		<?php if (have_posts()) : ?>
			<div class="b2v-archive-grid">
				<?php while (have_posts()) : the_post(); ?>
					<article class="b2v-post-card">
						<?php if (has_post_thumbnail()) : ?>
							<a href="<?php the_permalink(); ?>" class="b2v-post-card__thumb">
								<?php the_post_thumbnail('medium_large', ['loading' => 'lazy', 'decoding' => 'async']); ?>
							</a>
						<?php endif; ?>

						<div class="b2v-post-card__body">
							<div class="b2v-post-card__meta">
								<time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
									<?php echo esc_html(get_the_date()); ?>
								</time>
							</div>
							<h2 class="b2v-post-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<p class="b2v-post-card__excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<div class="b2v-pagination">
				<?php
				the_posts_pagination([
					'mid_size'  => 2,
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
				]);
				?>
			</div>
		<?php else : ?>
			<p class="b2v-text-muted b2v-text-center"><?php esc_html_e('Nessun articolo trovato.', 'b2vibe'); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
