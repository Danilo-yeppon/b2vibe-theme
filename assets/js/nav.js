(function () {
	function initNav() {
		const toggle = document.querySelector('.b2v-nav-toggle');
		const nav = document.querySelector('.b2v-nav');
		if (!toggle || !nav) return;

		toggle.addEventListener('click', () => {
			const open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', String(open));
		});

		// Close the menu after tapping any navigation link. Menu items can be
		// stored as absolute URLs (e.g. https://b2vibe.com/#chi-siamo), so we
		// can't rely on an href^="#" selector here.
		nav.querySelectorAll('a').forEach(link => {
			link.addEventListener('click', () => {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
			});
		});
	}

	// Run immediately when the DOM is already parsed. This keeps the menu
	// working even if the script is loaded async/deferred or injected late by
	// a performance/cache plugin, in which case DOMContentLoaded has already
	// fired and a DOMContentLoaded listener would never run.
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initNav);
	} else {
		initNav();
	}
})();
