<?php
/**
 * Generic page template.
 *
 * @package B2Vibe
 */

declare(strict_types=1);

get_header();
?>

<main class="b2v-content">
	<div class="b2v-container b2v-content--narrow">
		<?php while (have_posts()) : the_post(); ?>
			<h1><?php the_title(); ?></h1>
			<div class="b2v-content__body">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</div>
</main>

<?php get_footer(); ?>
