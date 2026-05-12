<?php
/**
 * Template for the "Prenota una call" page.
 * Displays the Contact Form 7 form with B2Vibe styling.
 *
 * @package B2Vibe
 */

declare(strict_types=1);

get_header();
?>

<main class="b2v-content b2v-call-page">
	<div class="b2v-container">

		<div class="b2v-call-page__grid">
			<!-- Left: info -->
			<div class="b2v-call-page__info">
				<span class="b2v-label"><?php esc_html_e('Contatti', 'b2vibe'); ?></span>
				<h1><?php esc_html_e('Prenota una call di 30 minuti', 'b2vibe'); ?></h1>
				<p class="b2v-call-page__desc">
					<?php esc_html_e('Valutiamo insieme se esiste un\'opportunit&agrave; reale per il tuo brand sui marketplace europei. Senza impegno, solo numeri chiari.', 'b2vibe'); ?>
				</p>

				<ul class="b2v-call-page__features">
					<li>
						<span class="b2v-call-page__check" aria-hidden="true">&#10003;</span>
						<?php esc_html_e('Analisi gratuita del tuo potenziale', 'b2vibe'); ?>
					</li>
					<li>
						<span class="b2v-call-page__check" aria-hidden="true">&#10003;</span>
						<?php esc_html_e('Nessun impegno, solo dati concreti', 'b2vibe'); ?>
					</li>
					<li>
						<span class="b2v-call-page__check" aria-hidden="true">&#10003;</span>
						<?php esc_html_e('Risposta entro 24 ore lavorative', 'b2vibe'); ?>
					</li>
					<li>
						<span class="b2v-call-page__check" aria-hidden="true">&#10003;</span>
						<?php esc_html_e('Call con un esperto marketplace', 'b2vibe'); ?>
					</li>
				</ul>
			</div>

			<!-- Right: form -->
			<div class="b2v-card b2v-call-page__form-card">
				<?php while (have_posts()) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div>
		</div>

	</div>
</main>

<?php get_footer(); ?>
