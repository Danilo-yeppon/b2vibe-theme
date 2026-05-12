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
					<?php the_post_thumbnail('large'); ?>
				</figure>
			<?php endif; ?>

			<div class="b2v-content__body">
				<?php the_content(); ?>
			</div>

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
