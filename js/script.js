(function($) {
	$(document).ready( function() {
		if ( $.isFunction( $.fn.wpColorPicker ) ) {
			$('.wp-color-picker').each( function() {
				$( this ).wpColorPicker();
			});
		}

		$( '#ftrdpsts_theme_style' ).change( function() {
			if ( $( this ).attr('checked') ) {
				$( '.ftrdpsts_theme_style' ).hide();
			} else {
				$( '.ftrdpsts_theme_style' ).show();
			}
		});

		/* add notice about changing in the settings page */
		$( '#ftrdpsts_settings_form input' ).bind( "change click select", function() {
			if ( $( this ).attr( 'type' ) != 'submit' ) {
				$( '.updated.fade' ).css( 'display', 'none' );
				$( '#ftrdpsts_settings_notice' ).css( 'display', 'block' );
			};
		});
	});
})(jQuery);