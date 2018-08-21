jQuery(document).ready(function($) {
  'use strict';

  $(document).on('click', '.rotativa-generate-pdf-fe', function(event) {
    event.preventDefault();

    var button = $(this),
        nonce  = button.data('nonce'),
        id     = button.data('id'),
        text   = button.text();

    $.ajax({
      type: 'POST',
      url: rotativa.ajaxurl,
      data: {
        id: id,
        nonce: nonce,
        action: 'rotativa_ajax_generate_pdf_fe'
      },
      beforeSend: function() {
        button.html( rotativa.generating_pdf );
      },
      success: function( response ) {
        if ( response.success === true ) {
          var data = JSON.parse( response.data );

          if ( data.error ) {

            swal({
              type: 'error',
              title: rotativa.pdf_error.title,
              text: data.error
            });

          } else {

            swal({
              title: rotativa.pdf_success.title,
              type: 'success',
              html: '<p>' + rotativa.pdf_success.description + '</p><p><a href="' + data.pdfUrl + '" class="button is-primary" download>' + rotativa.pdf_success.button_label + '</a></p>',
              showConfirmButton: false
            });

          }
        }
      },
      error: function( response ) {
        console.log( response );
      },
      complete: function() {
        button.html( text );
      }
    });
  });
});