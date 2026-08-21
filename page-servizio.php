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

$label    = (string) get_post_meta(get_the_ID(), 'b2v_service_label', true);
$intro    = (string) get_post_meta(get_the_ID(), 'b2v_service_intro', true);
$features = get_post_meta(get_the_ID(), 'b2v_service_features', true);
$benefits = get_post_meta(get_the_ID(), 'b2v_service_benefits', true);

// Le meta possono arrivare come stringa JSON (post meta manuale) oppure come array
// (ACF): normalizziamo entrambi i casi e scartiamo i valori non validi, così che
// una meta malformata nasconda la sezione invece di generare un errore fatale.
$features = is_string($features) ? json_decode($features, true) : $features;
$benefits = is_string($benefits) ? json_decode($benefits, true) : $benefits;

$features = is_array($features) ? array_values(array_filter($features, 'is_array')) : [];
$benefits = is_array($benefits) ? array_values(array_filter($benefits, 'is_scalar')) : [];

$features = array_map(
	static function (array $feat): array {
		return [
			'title' => is_scalar($feat['title'] ?? null) ? (string) $feat['title'] : '',
			'text'  => is_scalar($feat['text'] ?? null) ? (string) $feat['text'] : '',
		];
	},
	$features
);

$benefits = array_map(static fn($benefit): string => (string) $benefit, $benefits);

// Contenuto libero della pagina, ripulito da commenti di blocco e markup vuoto.
$body_raw  = preg_replace('/<!--.*?-->/s', '', (string) get_the_content());
$has_body  = trim(strip_tags((string) $body_raw, '<img><video><iframe><table>')) !== '';

// Senza b2v_service_intro il contenuto della pagina fa da introduzione nell'hero:
// in quel caso la sezione "Approfondimento" va omessa per non duplicarlo.
$show_body = $has_body && $intro !== '';
?>

<main class="b2v-content b2v-service">

	<!-- Hero -->
	<section class="b2v-service__hero">
		<div class="b2v-container">
			<?php if ($label) : ?>
				<span class="b2v-label"><?php echo esc_html($label); ?></span>
			<?php endif; ?>

			<h1><?php the_title(); ?></h1>

			<?php if ($intro !== '') : ?>
				<p class="b2v-service__intro"><?php echo esc_html($intro); ?></p>
			<?php elseif ($has_body) : ?>
				<div class="b2v-service__intro"><?php the_content(); ?></div>
			<?php endif; ?>

			<a href="<?php echo esc_url(b2vibe_link('/prenota-una-call/')); ?>" class="b2v-btn b2v-btn--primary">
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
					<h3><?php echo esc_html($feat['title']); ?></h3>
					<p><?php echo esc_html($feat['text']); ?></p>
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

	<!-- Approfondimento (contenuto libero della pagina) -->
	<?php if ($show_body) : ?>
	<section class="b2v-section b2v-service__content">
		<div class="b2v-container b2v-content--narrow b2v-content__body">
			<?php the_content(); ?>
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
				<a href="<?php echo esc_url(b2vibe_link('/prenota-una-call/')); ?>" class="b2v-btn b2v-btn--primary">
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
