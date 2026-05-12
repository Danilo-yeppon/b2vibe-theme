<?php
/**
 * Blog index template — displays on the "Blog" posts page.
 *
 * @package B2Vibe
 */

declare(strict_types=1);

get_header();
?>

<main class="b2v-content b2v-blog">
	<div class="b2v-container">

		<!-- Blog hero -->
		<header class="b2v-blog__header">
			<span class="b2v-label"><?php esc_html_e('Blog', 'b2vibe'); ?></span>
			<h1><?php esc_html_e('Articoli e approfondimenti', 'b2vibe'); ?></h1>
			<p class="b2v-blog__intro">
				<?php esc_html_e('Strategie, casi studio e novit&agrave; dal mondo dell\'ecommerce multicanale e dei marketplace europei.', 'b2vibe'); ?>
			</p>
		</header>

		<?php if (have_posts()) : ?>

			<div class="b2v-archive-grid">
				<?php while (have_posts()) : the_post(); ?>
					<article class="b2v-post-card">
						<?php if (has_post_thumbnail()) : ?>
							<a href="<?php the_permalink(); ?>" class="b2v-post-card__thumb" aria-hidden="true">
								<?php the_post_thumbnail('medium_large'); ?>
							</a>
						<?php else : ?>
							<a href="<?php the_permalink(); ?>" class="b2v-post-card__thumb b2v-post-card__thumb--placeholder" aria-hidden="true">
								<span class="b2v-post-card__placeholder-icon">&#9998;</span>
							</a>
						<?php endif; ?>

						<div class="b2v-post-card__body">
							<div class="b2v-post-card__meta">
								<time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
									<?php echo esc_html(get_the_date()); ?>
								</time>
								<?php
								$categories = get_the_category();
								if (! empty($categories)) :
								?>
									<span class="b2v-post-card__sep">&bull;</span>
									<a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="b2v-post-card__cat">
										<?php echo esc_html($categories[0]->name); ?>
									</a>
								<?php endif; ?>
							</div>

							<h2 class="b2v-post-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>

							<p class="b2v-post-card__excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>

							<a href="<?php the_permalink(); ?>" class="b2v-post-card__link">
								<?php esc_html_e('Leggi l\'articolo', 'b2vibe'); ?>
								<span aria-hidden="true">&rarr;</span>
							</a>
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

			<div class="b2v-blog__empty">
				<p><?php esc_html_e('Nessun articolo ancora pubblicato. I contenuti arriveranno presto!', 'b2vibe'); ?></p>
			</div>

		<?php endif; ?>

		<!-- CTA in fondo al blog -->
		<section class="b2v-blog__cta">
			<div class="b2v-card b2v-blog__cta-card">
				<h2><?php esc_html_e('Vuoi far crescere il tuo brand sui marketplace?', 'b2vibe'); ?></h2>
				<p><?php esc_html_e('Prenota una call gratuita di 30 minuti con il nostro team.', 'b2vibe'); ?></p>
				<a href="<?php echo esc_url(home_url('/prenota-una-call/')); ?>" class="b2v-btn b2v-btn--primary">
					<?php esc_html_e('Prenota la call', 'b2vibe'); ?>
					<span aria-hidden="true">&rarr;</span>
				</a>
			</div>
		</section>

	</div>
</main>

<?php get_footer(); ?>
