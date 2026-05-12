<?php
/**
 * Template Name: Pagina Servizio
 *
 * Layout: hero con label + heading + intro,
 * griglia feature cards, sezione vantaggi,
 * CTA finale verso la call.
 *
 * Custom fields (usabili anche senza ACF via post meta):
 *   b2v_service_label   — label in alto (es. "01 — ECOMMERCE MANAGEMENT")
 *   b2v_service_intro   — paragrafo introduttivo
 *   b2v_service_features — JSON array di feature [{title, text, icon}]
 *   b2v_service_benefits — JSON array di benefit stringhe
 *
 * @package B2Vibe
 */

declare(strict_types=1);

get_header();

while (have_posts()) : the_post();

$label    = get_post_meta(get_the_ID(), 'b2v_service_label', true);
$intro    = get_post_meta(get_the_ID(), 'b2v_service_intro', true);
$features = get_post_meta(get_the_ID(), 'b2v_service_features', true);
$benefits = get_post_meta(get_the_ID(), 'b2v_service_benefits', true);

$features = $features ? json_decode($features, true) : [];
$benefits = $benefits ? json_decode($benefits, true) : [];
?>

<main class="b2v-content b2v-service">

	<!-- Hero -->
	<section class="b2v-service__hero">
		<div class="b2v-container">
			<?php if ($label) : ?>
				<span class="b2v-label"><?php echo esc_html($label); ?></span>
			<?php endif; ?>

			<h1><?php the_title(); ?></h1>

			<?php if ($intro) : ?>
				<p class="b2v-service__intro"><?php echo esc_html($intro); ?></p>
			<?php else : ?>
				<div class="b2v-service__intro"><?php the_content(); ?></div>
			<?php endif; ?>

			<a href="<?php echo esc_url(home_url('/prenota-una-call/')); ?>" class="b2v-btn b2v-btn--primary">
				<?php esc_html_e('Richiedi informazioni', 'b2vibe'); ?>
				<span aria-hidden="true">&rarr;</span>
			</a>
		</div>
	</section>

	<!-- Features grid -->
	<?php if (! empty($features)) : ?>
	<section class="b2v-section b2v-service__features b2v-section--alt">
		<div class="b2v-container">
			<span class="b2v-label"><?php esc_html_e('Cosa include', 'b2vibe'); ?></span>
			<h2><?php esc_html_e('Il servizio nel dettaglio', 'b2vibe'); ?></h2>

			<div class="b2v-service__features-grid">
				<?php foreach ($features as $i => $feat) : ?>
				<div class="b2v-card b2v-service__feature-card">
					<span class="b2v-service__feature-num"><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
					<h3><?php echo esc_html($feat['title'] ?? ''); ?></h3>
					<p><?php echo esc_html($feat['text'] ?? ''); ?></p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- Benefits -->
	<?php if (! empty($benefits)) : ?>
	<section class="b2v-section b2v-service__benefits">
		<div class="b2v-container">
			<div class="b2v-service__benefits-grid">
				<div>
					<span class="b2v-label"><?php esc_html_e('Vantaggi', 'b2vibe'); ?></span>
					<h2><?php printf(esc_html__('Perch&eacute; scegliere %s con B2Vibe', 'b2vibe'), esc_html(get_the_title())); ?></h2>
				</div>
				<ul class="b2v-service__benefits-list">
					<?php foreach ($benefits as $b) : ?>
					<li>
						<span class="b2v-service__check" aria-hidden="true">&#10003;</span>
						<?php echo esc_html($b); ?>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- CTA -->
	<section class="b2v-cta-final">
		<div class="b2v-container">
			<div class="b2v-card b2v-cta-final__card">
				<span class="b2v-label"><?php esc_html_e('Inizia ora', 'b2vibe'); ?></span>
				<h2><?php esc_html_e('Vuoi saperne di pi&ugrave;?', 'b2vibe'); ?></h2>
				<p><?php esc_html_e('Prenota una call gratuita di 30 minuti e scopri come possiamo aiutare il tuo brand a crescere sui marketplace europei.', 'b2vibe'); ?></p>
				<a href="<?php echo esc_url(home_url('/prenota-una-call/')); ?>" class="b2v-btn b2v-btn--primary">
					<?php esc_html_e('Prenota la call di 30\'', 'b2vibe'); ?>
					<span aria-hidden="true">&rarr;</span>
				</a>
			</div>
		</div>
	</section>

</main>

<?php
endwhile;
get_footer();
?>
