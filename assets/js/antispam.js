/* B2Vibe anti-spam: fill the CF7 time-trap token from a non-cached endpoint. */
(function () {
	var cfg = window.b2vAntispam || {};
	var endpoint = cfg.endpoint || '/wp-json/b2vibe/v1/form-token';
	var fetchedAt = 0;

	function fill(token) {
		var inputs = document.querySelectorAll('form.wpcf7-form input[name="_b2v_ts"]');
		for (var i = 0; i < inputs.length; i++) {
			inputs[i].value = token;
		}
	}

	function load() {
		fetchedAt = Date.now();
		fetch(endpoint + (endpoint.indexOf('?') === -1 ? '?' : '&') + '_=' + fetchedAt, {
			credentials: 'same-origin',
			cache: 'no-store'
		})
			.then(function (r) { return r.ok ? r.json() : null; })
			.then(function (d) { if (d && d.token) { fill(d.token); } })
			.catch(function () {});
	}

	function init() {
		if (!document.querySelector('form.wpcf7-form')) {
			return;
		}
		load();
		// Tab left open for hours: refresh the token when the user comes back.
		document.addEventListener('visibilitychange', function () {
			if (!document.hidden && Date.now() - fetchedAt > 3 * 60 * 60 * 1000) {
				load();
			}
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
