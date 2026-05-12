<footer class="b2v-footer" role="contentinfo">
	<div class="b2v-container">
		<div class="b2v-footer__grid">
			<div class="b2v-footer__brand">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="b2v-logo">
						<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo-b2vibe.svg'); ?>" alt="B2Vibe" class="b2v-logo__img" width="160" height="24">
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
					<li><span class="b2v-text-muted"><?php esc_html_e('Paderno Dugnano (MB)', 'b2vibe'); ?></span></li>
				</ul>
			</div>
		</div>

		<div class="b2v-footer__bottom">
			<span>&copy; <?php echo esc_html(date('Y')); ?> B2Vibe. <?php esc_html_e('Tutti i diritti riservati.', 'b2vibe'); ?></span>
			<span>P.IVA IT00000000000</span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
