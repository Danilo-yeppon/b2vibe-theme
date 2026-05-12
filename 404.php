<?php
/**
 * 404 template.
 *
 * @package B2Vibe
 */

declare(strict_types=1);

get_header();
?>

<main class="b2v-404">
	<span class="b2v-404__code" aria-hidden="true">404</span>
	<h1><?php esc_html_e('Pagina non trovata', 'b2vibe'); ?></h1>
	<p><?php esc_html_e('La pagina che stai cercando non esiste o &egrave; stata spostata.', 'b2vibe'); ?></p>
	<a href="<?php echo esc_url(home_url('/')); ?>" class="b2v-btn b2v-btn--primary">
		<?php esc_html_e('Torna alla home', 'b2vibe'); ?>
	</a>
</main>

<?php get_footer(); ?>
