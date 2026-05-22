<?php
/**
 * Front page template.
 *
 * @package B2Vibe
 */

declare(strict_types=1);

get_header();
?>

<!-- 1. HERO -->
<section class="b2v-hero" id="hero">
	<div class="b2v-container b2v-hero__inner">
		<div class="b2v-hero__badge">
			<?php esc_html_e('E-commerce Service Provider, Full Outsourcing Multicanale', 'b2vibe'); ?>
		</div>

		<h1>
			<?php esc_html_e('Making sales', 'b2vibe'); ?>
			<br><span class="b2v-accent"><?php esc_html_e('effectively simple.', 'b2vibe'); ?></span>
		</h1>

		<p class="b2v-hero__sub">
			<?php esc_html_e('Nati da 15+ anni di esperienza Yeppon e oltre 1 milione di ordini spediti in Europa. Oggi mettiamo questa competenza al servizio del tuo brand, gestendo ecommerce multicanale, logistica, fiscalit&agrave; e customer care.', 'b2vibe'); ?>
		</p>

		<div class="b2v-hero__actions">
			<a href="<?php echo esc_url(home_url('/prenota-una-call/')); ?>" class="b2v-btn b2v-btn--primary">
				<?php esc_html_e('Prenota una call di 30\'', 'b2vibe'); ?>
				<span aria-hidden="true">&rarr;</span>
			</a>
			<a href="#servizi" class="b2v-btn b2v-btn--outline">
				<?php esc_html_e('Scopri i servizi', 'b2vibe'); ?>
			</a>
		</div>
	</div>
</section>

<!-- 2. TICKER MARKETPLACE -->
<div class="b2v-ticker" aria-label="<?php esc_attr_e('Marketplace partner', 'b2vibe'); ?>">
	<p class="b2v-ticker__label">
		<?php esc_html_e('Vendiamo sui principali marketplace europei', 'b2vibe'); ?>
	</p>
	<div class="b2v-ticker__track" aria-hidden="true">
		<?php for ($i = 0; $i < 4; $i++) : ?>
		<div class="b2v-ticker__group">
			<span class="b2v-ticker__item">Amazon</span>
			<span class="b2v-ticker__item">eBay</span>
			<span class="b2v-ticker__item">FNAC</span>
			<span class="b2v-ticker__item">Kaufland</span>
			<span class="b2v-ticker__item">ManoMano</span>
			<span class="b2v-ticker__item">Leroy Merlin</span>
			<span class="b2v-ticker__item">Stockly</span>
			<span class="b2v-ticker__item">Digitec</span>
			<span class="b2v-ticker__item">MediaMarkt</span>
			<span class="b2v-ticker__item">BricoBravo</span>
		</div>
		<?php endfor; ?>
	</div>
</div>

<!-- 3. LA NOSTRA STORIA -->
<section class="b2v-section b2v-problema" id="storia">
	<div class="b2v-container b2v-problema__inner">
		<span class="b2v-label"><?php esc_html_e('La nostra storia', 'b2vibe'); ?></span>
		<h2><?php esc_html_e('Da Yeppon a B2Vibe: 15 anni di ecommerce, ora al servizio del tuo brand.', 'b2vibe'); ?></h2>
		<p>
			<?php esc_html_e('B2Vibe nasce da una costola di Yeppon, uno dei principali ecommerce italiani. In oltre 15 anni abbiamo spedito pi&ugrave; di 1 milione di ordini in tutta Europa, affrontando ogni sfida operativa: logistica, fiscalit&agrave; internazionale, compliance e customer care multilingua. Oggi mettiamo tutta questa esperienza al servizio di altre aziende che vogliono vendere online senza reinventare la ruota.', 'b2vibe'); ?>
		</p>
	</div>
</section>

<!-- 3b. I NUMERI -->
<section class="b2v-section b2v-stats" id="numeri">
	<div class="b2v-container">
		<div class="b2v-stats__grid">
			<div class="b2v-stats__item">
				<span class="b2v-stats__number">15+</span>
				<span class="b2v-stats__label"><?php esc_html_e('Anni di esperienza', 'b2vibe'); ?></span>
			</div>
			<div class="b2v-stats__item">
				<span class="b2v-stats__number">1M+</span>
				<span class="b2v-stats__label"><?php esc_html_e('Ordini spediti in Europa', 'b2vibe'); ?></span>
			</div>
			<div class="b2v-stats__item">
				<span class="b2v-stats__number">10+</span>
				<span class="b2v-stats__label"><?php esc_html_e('Marketplace gestiti', 'b2vibe'); ?></span>
			</div>
			<div class="b2v-stats__item">
				<span class="b2v-stats__number">5</span>
				<span class="b2v-stats__label"><?php esc_html_e('Lingue di assistenza', 'b2vibe'); ?></span>
			</div>
		</div>
	</div>
</section>

<!-- 4. A CHI CI RIVOLGIAMO -->
<section class="b2v-section b2v-target" id="chi-siamo">
	<div class="b2v-container">
		<span class="b2v-label"><?php esc_html_e('A chi ci rivolgiamo', 'b2vibe'); ?></span>
		<h2><?php esc_html_e('Il partner ideale per chi vuole crescere online, senza complicazioni.', 'b2vibe'); ?></h2>
		<p><?php esc_html_e('Lavoriamo con brand e produttori che vogliono espandersi sui marketplace europei senza moltiplicare team e costi interni.', 'b2vibe'); ?></p>

		<div class="b2v-target__grid">
			<div class="b2v-card b2v-target__card">
				<div class="b2v-target__icon" aria-hidden="true">&#9878;</div>
				<h3><?php esc_html_e('Brand D2C', 'b2vibe'); ?></h3>
				<p><?php esc_html_e('Marchi con un proprio ecommerce che vogliono espandersi sui marketplace senza gestire la complessit&agrave; operativa.', 'b2vibe'); ?></p>
			</div>

			<div class="b2v-card b2v-target__card">
				<div class="b2v-target__icon" aria-hidden="true">&#9881;</div>
				<h3><?php esc_html_e('Produttori e PMI', 'b2vibe'); ?></h3>
				<p><?php esc_html_e('Aziende manifatturiere che vogliono vendere direttamente al consumatore finale sui principali canali europei.', 'b2vibe'); ?></p>
			</div>

			<div class="b2v-card b2v-target__card">
				<div class="b2v-target__icon" aria-hidden="true">&#9733;</div>
				<h3><?php esc_html_e('Retailer & Distributori', 'b2vibe'); ?></h3>
				<p><?php esc_html_e('Aziende con cataloghi ampi che necessitano di un partner per la gestione multicanale scalabile e conforme.', 'b2vibe'); ?></p>
			</div>
		</div>
	</div>
</section>

<!-- 5. I NOSTRI SERVIZI -->
<section class="b2v-section b2v-servizi" id="servizi">
	<div class="b2v-container">
		<div class="b2v-servizi__ticker" aria-hidden="true">
			<div class="b2v-servizi__ticker-track">
				<?php for ($i = 0; $i < 8; $i++) : ?>
				<span class="b2v-servizi__ticker-item">I NOSTRI SERVIZI &nbsp;&bull;&nbsp;</span>
				<?php endfor; ?>
			</div>
		</div>

		<h2><?php esc_html_e('Un ecosistema completo per il tuo ecommerce.', 'b2vibe'); ?></h2>

		<div class="b2v-servizi__grid">
			<a href="<?php echo esc_url(home_url('/ecommerce-management/')); ?>" class="b2v-card b2v-servizi__card">
				<span class="b2v-servizi__num">01</span>
				<h3><?php esc_html_e('Ecommerce Management', 'b2vibe'); ?></h3>
				<p><?php esc_html_e('Gestione completa dei tuoi canali di vendita: listing, pricing, promozioni e ottimizzazione delle performance su ogni marketplace.', 'b2vibe'); ?></p>
				<span class="b2v-servizi__link"><?php esc_html_e('Scopri di pi&ugrave;', 'b2vibe'); ?> &rarr;</span>
			</a>

			<a href="<?php echo esc_url(home_url('/merchant-of-record/')); ?>" class="b2v-card b2v-servizi__card">
				<span class="b2v-servizi__num">02</span>
				<h3><?php esc_html_e('Merchant of Record', 'b2vibe'); ?></h3>
				<p><?php esc_html_e('Vendiamo per tuo conto come entit&agrave; fiscale. Gestiamo IVA, fatturazione e compliance in ogni paese europeo.', 'b2vibe'); ?></p>
				<span class="b2v-servizi__link"><?php esc_html_e('Scopri di pi&ugrave;', 'b2vibe'); ?> &rarr;</span>
			</a>

			<a href="<?php echo esc_url(home_url('/logistica-e-magazzino/')); ?>" class="b2v-card b2v-servizi__card">
				<span class="b2v-servizi__num">03</span>
				<h3><?php esc_html_e('Logistica e Magazzino', 'b2vibe'); ?></h3>
				<p><?php esc_html_e('Magazzino certificato Amazon Prime a Paderno Dugnano. Picking, packing, spedizioni e gestione resi integrata.', 'b2vibe'); ?></p>
				<span class="b2v-servizi__link"><?php esc_html_e('Scopri di pi&ugrave;', 'b2vibe'); ?> &rarr;</span>
			</a>

			<a href="<?php echo esc_url(home_url('/customer-care/')); ?>" class="b2v-card b2v-servizi__card">
				<span class="b2v-servizi__num">04</span>
				<h3><?php esc_html_e('Customer Care', 'b2vibe'); ?></h3>
				<p><?php esc_html_e('Assistenza pre e post vendita in 5 lingue con SLA stringenti. Gestiamo ogni interazione per proteggere la reputazione del brand.', 'b2vibe'); ?></p>
				<span class="b2v-servizi__link"><?php esc_html_e('Scopri di pi&ugrave;', 'b2vibe'); ?> &rarr;</span>
			</a>
		</div>
	</div>
</section>

<!-- 6. PERCHE B2VIBE — CONFRONTO -->
<section class="b2v-section b2v-confronto" id="vantaggi">
	<div class="b2v-container">
		<span class="b2v-label"><?php esc_html_e('Perch&eacute; B2Vibe', 'b2vibe'); ?></span>
		<h2><?php esc_html_e('Gestione in-house vs. Gestione B2Vibe.', 'b2vibe'); ?></h2>
		<p class="b2v-confronto__sub"><?php esc_html_e('Riduzione fino all\'80% del carico operativo interno.', 'b2vibe'); ?></p>

		<table class="b2v-confronto__table">
			<thead>
				<tr>
					<th><?php esc_html_e('Voce', 'b2vibe'); ?></th>
					<th><?php esc_html_e('In-house', 'b2vibe'); ?></th>
					<th><?php esc_html_e('B2Vibe', 'b2vibe'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$rows = [
					__('Apertura e gestione IVA estere', 'b2vibe'),
					__('Gestione burocrazia e compliance', 'b2vibe'),
					__('Personale amministrativo / logistica', 'b2vibe'),
					__('IT e tech stack multicanale', 'b2vibe'),
					__('Spedizioni Amazon Prime', 'b2vibe'),
					__('Rischio blocco account / compliance', 'b2vibe'),
				];
				foreach ($rows as $row) :
				?>
				<tr>
					<td><?php echo esc_html($row); ?></td>
					<td class="b2v-cross" aria-label="<?php esc_attr_e('Non incluso', 'b2vibe'); ?>">&#10060;</td>
					<td class="b2v-check" aria-label="<?php esc_attr_e('Incluso', 'b2vibe'); ?>">&#10003; <?php esc_html_e('Incluso', 'b2vibe'); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>

<!-- 7. CANALI GESTITI -->
<section class="b2v-section b2v-canali b2v-text-center" id="canali">
	<div class="b2v-container">
		<span class="b2v-label"><?php esc_html_e('Canali gestiti', 'b2vibe'); ?></span>
		<h2><?php esc_html_e('Un unico brand, ovunque siano i tuoi clienti.', 'b2vibe'); ?></h2>

		<div class="b2v-canali__grid">
			<?php
			$channels = [
				'Amazon Prime', 'eBay', 'FNAC', 'Kaufland', 'Leroy Merlin',
				'ManoMano', 'Stockly', 'Digitec', 'MediaMarkt', 'BricoBravo',
			];
			foreach ($channels as $ch) :
			?>
			<span class="b2v-canali__badge"><?php echo esc_html($ch); ?></span>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 8. ULTIMI ARTICOLI -->
<?php
$latest_posts = new WP_Query([
	'posts_per_page' => 3,
	'post_status'    => 'publish',
	'no_found_rows'  => true,
]);
if ($latest_posts->have_posts()) :
?>
<section class="b2v-section b2v-latest" id="articoli">
	<div class="b2v-container">
		<div class="b2v-latest__header">
			<div>
				<span class="b2v-label"><?php esc_html_e('Dal nostro blog', 'b2vibe'); ?></span>
				<h2><?php esc_html_e('Articoli e approfondimenti', 'b2vibe'); ?></h2>
			</div>
			<a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="b2v-btn b2v-btn--outline">
				<?php esc_html_e('Vedi tutti', 'b2vibe'); ?>
				<span aria-hidden="true">&rarr;</span>
			</a>
		</div>

		<div class="b2v-archive-grid">
			<?php while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
				<article class="b2v-post-card">
					<?php if (has_post_thumbnail()) : ?>
						<a href="<?php the_permalink(); ?>" class="b2v-post-card__thumb" aria-hidden="true">
							<?php the_post_thumbnail('medium_large'); ?>
						</a>
					<?php endif; ?>
					<div class="b2v-post-card__body">
						<div class="b2v-post-card__meta">
							<time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
								<?php echo esc_html(get_the_date()); ?>
							</time>
						</div>
						<h3 class="b2v-post-card__title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<p class="b2v-post-card__excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();
endif;
?>

<!-- 9. CTA FINALE -->
<section class="b2v-cta-final" id="cta">
	<div class="b2v-container">
		<div class="b2v-card b2v-cta-final__card">
			<span class="b2v-label"><?php esc_html_e('Servizi', 'b2vibe'); ?></span>
			<h2><?php esc_html_e('Valutiamo insieme l\'opportunit&agrave; di crescita.', 'b2vibe'); ?></h2>
			<p><?php esc_html_e('Valutiamo insieme se esiste un\'opportunit&agrave; reale per il tuo brand. Senza impegno, solo numeri chiari.', 'b2vibe'); ?></p>
			<a href="<?php echo esc_url(home_url('/prenota-una-call/')); ?>" class="b2v-btn b2v-btn--primary">
				<?php esc_html_e('Prenota la call di 30\'', 'b2vibe'); ?>
				<span aria-hidden="true">&rarr;</span>
			</a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
