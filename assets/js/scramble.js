/**
 * Scramble Text Effect
 * Letters compose one-by-one from random glyphs.
 * Usage: <span data-scramble="Making sales">Making sales</span>
 */
(function () {
	'use strict';

	const GLYPHS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ#%&@/\\<>*+';
	const TICK   = 32;   // ms per frame
	const REVEAL = 2;    // frames between each letter reveal

	function randomGlyph() {
		return GLYPHS[Math.floor(Math.random() * GLYPHS.length)];
	}

	function scramble(el) {
		const text     = el.getAttribute('data-scramble');
		const total    = text.length;
		let revealed   = 0;
		let frameCount = 0;

		// Start blank with glyphs
		el.style.visibility = 'visible';

		const interval = setInterval(function () {
			let out = '';
			for (let i = 0; i < total; i++) {
				if (i < revealed) {
					out += text[i];
				} else if (text[i] === ' ') {
					out += ' ';
				} else {
					out += randomGlyph();
				}
			}
			el.textContent = out;

			frameCount++;
			if (frameCount % REVEAL === 0) {
				// Skip spaces for reveal counting
				while (revealed < total && text[revealed] === ' ') {
					revealed++;
				}
				revealed++;
			}

			if (revealed >= total) {
				el.textContent = text;
				clearInterval(interval);
			}
		}, TICK);
	}

	function init() {
		var targets = document.querySelectorAll('[data-scramble]');
		if (!targets.length) return;

		// Use IntersectionObserver so it fires when hero is visible
		if ('IntersectionObserver' in window) {
			var observer = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						scramble(entry.target);
						observer.unobserve(entry.target);
					}
				});
			}, { threshold: 0.3 });

			targets.forEach(function (el) {
				el.style.visibility = 'hidden';
				observer.observe(el);
			});
		} else {
			// Fallback: run immediately
			targets.forEach(scramble);
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
