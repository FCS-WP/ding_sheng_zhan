;(function ( $ ) {
	'use strict';

	/**
	 * @TODO Code a function the calculate available combination instead of use WC hooks
	 */
	$.fn.tawcvs_variation_swatches_form = function () {
		return this.each( function() {
			var $form = $( this ),
				clicked = null,
				selected = [];

			$form
				.addClass( 'swatches-support' )
				.on( 'click', '.swatch', function ( e ) {
					e.preventDefault();
					var $el = $( this ),
						$select = $el.closest( '.value' ).find( 'select' ),
						attribute_name = $select.data( 'attribute_name' ) || $select.attr( 'name' ),
						value = $el.data( 'value' );

                    if ( $el.hasClass( 'disabled' ) ) {
                        return;
                    }

					$select.trigger( 'focusin' );

					// Check if this combination is available
					if ( ! $select.find( 'option[value="' + value + '"]' ).length ) {
						$el.siblings( '.swatch' ).removeClass( 'selected' );
						$select.val( '' ).change();
						$form.trigger( 'tawcvs_no_matching_variations', [$el] );
						return;
					}

					clicked = attribute_name;

					if ( selected.indexOf( attribute_name ) === -1 ) {
						selected.push(attribute_name);
					}

					if ( $el.hasClass( 'selected' ) ) {
						$select.val( '' );
						$el.removeClass( 'selected' );

						delete selected[selected.indexOf(attribute_name)];
					} else {
						$el.addClass( 'selected' ).siblings( '.selected' ).removeClass( 'selected' );
						$select.val( value );
					}

					$select.change();
				} )
				.on( 'click', '.reset_variations', function () {
                    $form.find( '.swatch.selected' ).removeClass( 'selected' );
                    $form.find( '.swatch.disabled' ).removeClass( 'disabled' );
					selected = [];
				} )
				.on( 'woocommerce_update_variation_values', function() {
                setTimeout( function() {
                    $form.find( 'tbody tr' ).each( function() {
                        var $variationRow = $( this ),
                            $options = $variationRow.find( 'select' ).find( 'option' ),
                            $selected = $options.filter( ':selected' ),
                            values = [];

                        $options.each( function( index, option ) {
                            if ( option.value !== '' ) {
                                values.push( option.value );
                            }
                        } );

                        $variationRow.find( '.swatch' ).each( function() {
                            var $swatch = $( this ),
                                value = $swatch.attr( 'data-value' );

                            if ( values.indexOf( value ) > -1 ) {
                                $swatch.removeClass( 'disabled' );
                            } else {
                                $swatch.addClass( 'disabled' );

                                if ( $selected.length && value === $selected.val() ) {
                                    $swatch.removeClass( 'selected' );
                                }
                            }
                        } );
                    } );
                }, 100 );
            } )
				.on( 'tawcvs_no_matching_variations', function() {
					window.alert( wc_add_to_cart_variation_params.i18n_no_matching_variations_text );
				} );
		} );
	};

	$( function () {
		var $form = $( '.variations_form' );

		$form.tawcvs_variation_swatches_form();

		if ( tawcvs.tooltip === 'yes' && $.fn.tooltip ) {
			$form.find('.swatch').tooltip( {
				classes: { 'ui-tooltip': 'tawcvs-tooltip' },
				tooltipClass : 'tawcvs-tooltip',
				position: { my: 'center bottom', at: 'center top-13' },
				create: function () { $('.ui-helper-hidden-accessible').remove(); }
			} );
		}

		$( document.body ).trigger( 'tawcvs_initialized' );
	} );
})( jQuery );