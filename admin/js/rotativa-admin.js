jQuery(document).ready(function($) {
	'use strict';

	$('.rotativa-hq-metabox .toggle-popup').on('click', function(event) {
		event.preventDefault();
		
		$('.rotativa-hq-popup-settings').addClass('is-active');
	});
	$('.rotativa-hq-popup-settings-overlay').on('click', function(event) {
		event.preventDefault();

		$('.rotativa-hq-popup-settings').removeClass('is-active');
	});
	$('.toggle-additional-pdf-settings').on('click', function(event) {
		event.preventDefault();

		$(this).toggleClass('is-active');
		$('.additional-pdf-settings').toggleClass('is-active');
	});
});
