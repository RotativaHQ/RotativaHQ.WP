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

    function empty(e) {
        switch (e) {
            case "":
            case 0:
            case "0":
            case null:
            case false:
            case typeof this === "undefined":
                return true;
            default:
                return false;
        }
    }

	$('.rotativa-generate-pdf').on('click', function(event) {
		event.preventDefault();

		var file_name = $('#pdf-item-file-name').val(),
			margin_top = $('#pdf-item-margin-top').val(),
			margin_right = $('#pdf-item-margin-right').val(),
			margin_bottom = $('#pdf-item-margin-bottom').val(),
			margin_left = $('#pdf-item-margin-left').val(),
			gray = false;

		if ( $('#pdf-item-grayscale').is(':checked') ) {

			gray = true;

		}

		if ( empty( file_name ) ) {

			file_name = null;

		}

		if ( empty( margin_top ) ) {

			margin_top = null;

		}

        if ( empty( margin_right ) ) {

            margin_right = null;

        }

        if ( empty( margin_bottom ) ) {

            margin_bottom = null;

        }

        if ( empty( margin_left ) ) {

            margin_left = null;

        }

        // Create AJAX function and send there everything.
	});
});
