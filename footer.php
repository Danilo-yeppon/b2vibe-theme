<footer class="b2v-footer" role="contentinfo">
	<div class="b2v-container">
		<div class="b2v-footer__grid">
			<div class="b2v-footer__brand">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="b2v-logo">
						<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo-b2vibe.png'); ?>" alt="B2Vibe" class="b2v-logo__img" width="160" height="24">
					</a>
				<p><?php esc_html_e('E-commerce Full Outsourcing & Merchant of Record. Gestiamo la complessit&agrave; per far crescere il tuo brand.', 'b2vibe'); ?></p>
			</div>

			<div class="b2v-footer__col">
				<h4><?php esc_html_e('Servizi', 'b2vibe'); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url(home_url('/ecommerce-management/')); ?>"><?php esc_html_e('Ecommerce Management', 'b2vibe'); ?></a></li>
					<li><a href="<?php echo esc_url(home_url('/merchant-of-record/')); ?>"><?php esc_html_e('Merchant of Record', 'b2vibe'); ?></a></li>
					<li><a href="<?php echo esc_url(home_url('/logistica-e-magazzino/')); ?>"><?php esc_html_e('Logistica e Magazzino', 'b2vibe'); ?></a></li>
					<li><a href="<?php echo esc_url(home_url('/customer-care/')); ?>"><?php esc_html_e('Customer Care', 'b2vibe'); ?></a></li>
				</ul>
			</div>

			<div class="b2v-footer__col">
				<h4><?php esc_html_e('Azienda', 'b2vibe'); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url(home_url('/#chi-siamo')); ?>"><?php esc_html_e('Chi siamo', 'b2vibe'); ?></a></li>
					<li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('Blog', 'b2vibe'); ?></a></li>
					<li><a href="<?php echo esc_url(home_url('/prenota-una-call/')); ?>"><?php esc_html_e('Contatti', 'b2vibe'); ?></a></li>
					<li><a href="#"><?php esc_html_e('Privacy Policy', 'b2vibe'); ?></a></li>
					<li><a href="#"><?php esc_html_e('Cookie Policy', 'b2vibe'); ?></a></li>
				</ul>
			</div>

			<div class="b2v-footer__col">
				<h4><?php esc_html_e('Contatti', 'b2vibe'); ?></h4>
				<ul>
					<li><a href="mailto:info@b2vibe.com">info@b2vibe.com</a></li>
					<li><span class="b2v-text-muted">Sede Operativa: Via Santi 11/13</span></li>
					<li><span class="b2v-text-muted">20037 Paderno Dugnano (MI)</span></li>
				</ul>
			</div>
		</div>

		<div class="b2v-footer__legal">
			<p>B2VIBE S.r.l. &mdash; Sede Legale: Via Paradiso, 5 &ndash; 20831 Seregno (MB) &mdash; REA: MB &ndash; 2767890</p>
			<p>P.IVA 14234560960 &mdash; Codice Univoco: SUBM70N &mdash; Capitale sociale &euro; 1.000.000</p>
		</div>

		<div class="b2v-footer__bottom">
			<span>&copy; <?php echo esc_html(date('Y')); ?> B2VIBE S.r.l. <?php esc_html_e('Tutti i diritti riservati.', 'b2vibe'); ?></span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
