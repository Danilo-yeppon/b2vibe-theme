(function () {
	// Event delegation on the document so the menu works no matter WHEN this
	// script runs (normal, async, defer, or injected late by a performance/
	// cache plugin) and even if the header markup is re-rendered after load.
	// `document` always exists by the time any script executes, so there is no
	// DOMContentLoaded race and no dependency on the elements existing yet.
	document.addEventListener('click', function (e) {
		// Toggle the menu when the hamburger button (or one of its <span>s) is tapped.
		const toggle = e.target.closest('.b2v-nav-toggle');
		if (toggle) {
			const nav = document.querySelector('.b2v-nav');
			if (!nav) return;
			const open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', String(open));
			return;
		}

		// Close the menu after tapping any link inside it. Menu items can be
		// stored as absolute URLs (e.g. https://b2vibe.com/#chi-siamo), so we
		// can't rely on an href^="#" selector here.
		const link = e.target.closest('.b2v-nav a');
		if (link) {
			const nav = link.closest('.b2v-nav') || document.querySelector('.b2v-nav');
			const btn = document.querySelector('.b2v-nav-toggle');
			if (nav) nav.classList.remove('is-open');
			if (btn) btn.setAttribute('aria-expanded', 'false');
		}
	});
})();
