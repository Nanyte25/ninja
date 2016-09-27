(function () {

	"use strict";

	function open_dialog (title, href) {

		var lightbox = LightboxManager.ajax_form_from_href(title, href);

		window.location.hash = 'lightbox:' + encodeURIComponent(title) + ':' + encodeURIComponent(href);

		$(lightbox.node).one('click', 'input[type="reset"]', function () {
			lightbox.remove();
		});

		$(lightbox.node).one('submit', 'form', function (e) {

			var data = new FormData(this);
			e.preventDefault();

			$.ajax({
				url: this.getAttribute('action'),
				data: data,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function (response) {

					Notify.message(response, {
						type: 'success'
					});

					setTimeout(function () {
						window.location.reload();
					}, 2000);

				},
				fail: function () {
					Notify.message(reponse, {
						sticky: true,
						type: 'error'
					});
				},
				complete: function (xhr) {
					lightbox.remove();
				}
			});

		});

	}

	$(document).on('click', '.command-ajax-link', function (e) {

		var href = $(this).attr('href');
		var title = $(this).text();

		open_dialog(title, href);

		e.preventDefault();
		return false;

	});

	$(window).load(function () {

		var hash = window.location.hash;

		if (hash.match(/^\#lightbox/)) {

			hash = hash.split(':');
			hash.shift();

			var title = hash.shift();
			var href = hash.shift();

			open_dialog(
				decodeURIComponent(title),
				decodeURIComponent(href)
			);

		}
	})


})();
