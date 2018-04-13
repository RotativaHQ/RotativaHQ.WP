jQuery(document).ready(function($) {
	'use strict';

	$('.rotativa-hq-metabox .toggle-popup').on('click', function(event) {
		event.preventDefault();
		
		$('.rotativa-hq-popup-settings').addClass('is-active');
		$('#pdf-item-file-name').focus();
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

		var file_name     = $('#pdf-item-file-name').val(),
			margin_top    = $('#pdf-item-margin-top').val(),
			margin_right  = $('#pdf-item-margin-right').val(),
			margin_bottom = $('#pdf-item-margin-bottom').val(),
			margin_left   = $('#pdf-item-margin-left').val(),
			gray          = false,
			nonce         = $(this).data('nonce'),
			id            = $(this).data('id'),
			label         = $(this).html(),
			label_active  = $(this).data( 'active-label' ),
			button        = $(this);

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

        $.ajax({
        	type: 'POST',
        	url: rotativa.ajaxurl,
        	data: {
        		file_name: file_name,
        		margin_top: margin_top,
        		margin_right: margin_right,
        		margin_bottom: margin_bottom,
        		margin_left: margin_left,
        		gray: gray,
        		nonce: nonce,
        		id: id,
        		action: 'ajax_generate_pdf'
        	},
        	beforeSend: function() {

        	    button.html( label_active );

        	},
        	success: function( response ) {

        		if ( response.success === true ) {
        		  var data = JSON.parse( response.data );

        		  swal({
                title: rotativa.pdf_success.title,
                type: 'success',
                html: '<p>' + rotativa.pdf_success.description + '</p><p><a href="' + data.pdfUrl + '" class="button is-primary" download>' + rotativa.pdf_success.button_label + '</a></p>',
                showConfirmButton: false
              });
						}

        	},
        	error: function( response ) {

        	    console.log( response );
        	    
        	},
        	complete: function() {

        	    button.html( label );
        	    $('.rotativa-hq-popup-settings').removeClass('is-active');

        	}
        });
	});
});
