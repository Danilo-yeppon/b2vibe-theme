function b2vNavInit() {
	const toggle = document.querySelector('.b2v-nav-toggle');
	const nav = document.querySelector('.b2v-nav');
	if (!toggle || !nav) return;

	toggle.addEventListener('click', () => {
		const isOpen = nav.classList.toggle('is-open');
		nav.style.display = isOpen ? 'flex' : '';
		toggle.setAttribute('aria-expanded', String(isOpen));
	});

	document.addEventListener('click', (e) => {
		if (nav.classList.contains('is-open') && !nav.contains(e.target) && !toggle.contains(e.target)) {
			nav.classList.remove('is-open');
			nav.style.display = '';
			toggle.setAttribute('aria-expanded', 'false');
		}
	});

	nav.querySelectorAll('a').forEach(link => {
		link.addEventListener('click', () => {
			nav.classList.remove('is-open');
			nav.style.display = '';
			toggle.setAttribute('aria-expanded', 'false');
		});
	});
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', b2vNavInit);
} else {
	b2vNavInit();
}
