jQuery(document).ready(function ($) {
    'use strict';

    var $body = $(document.body);

    $body.find('.fm_categories_show_more').each(function () {
        var $this = $(this),
            $els = $this.closest('.widget-content').find('.fm_categories_show_more_els').closest('p');

        if( $this.is(":checked") ) {
            $els.show();
        } else {
            $els.hide();
        }
    });

    $body.on('click', '.fm_categories_show_more', function (e) {

        var $this = $(this),
            $els = $this.closest('.widget-content').find('.fm_categories_show_more_els').closest('p');

        if( $this.is(":checked") ) {
            $els.show();
        } else {
            $els.hide();
        }
    });

    $body.find('.fm_categories_show_children_only').each(function () {
        var $this = $(this),
            $els = $this.closest('.widget-content').find('.fm_categories_show_children_only_els').closest('p');

        if( $this.is(":checked") ) {
            $els.show();
        } else {
            $els.hide();
        }
    });

    $body.on('click', '.fm_categories_show_children_only', function (e) {

        var $this = $(this),
            $els = $this.closest('.widget-content').find('.fm_categories_show_children_only_els').closest('p');

        if( $this.is(":checked") ) {
            $els.show();
        } else {
            $els.hide();
        }
    });

    $(document).on( 'widget-updated', function ($el, widget) {
        var $show_more_chek = widget.find('.fm_categories_show_more'),
            $show_more_els = widget.find('.widget-content').find('.fm_categories_show_more_els').closest('p'),
            $children_chek = widget.find('.fm_categories_show_children_only'),
            $children_els = widget.find('.widget-content').find('.fm_categories_show_children_only_els').closest('p');

        if( $show_more_chek.is(":checked") ) {
            $show_more_els.show();
        } else {
            $show_more_els.hide();
        }

        if( $children_chek.is(":checked") ) {
            $children_els.show();
        } else {
            $children_els.hide();
        }

    });

});