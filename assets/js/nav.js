document.addEventListener('DOMContentLoaded', () => {
	const toggle = document.querySelector('.b2v-nav-toggle');
	const nav = document.querySelector('.b2v-nav');
	if (!toggle || !nav) return;

	toggle.addEventListener('click', () => {
		const open = nav.classList.toggle('is-open');
		toggle.setAttribute('aria-expanded', String(open));
	});

	nav.querySelectorAll('a[href^="#"]').forEach(link => {
		link.addEventListener('click', () => {
			nav.classList.remove('is-open');
			toggle.setAttribute('aria-expanded', 'false');
		});
	});
});
