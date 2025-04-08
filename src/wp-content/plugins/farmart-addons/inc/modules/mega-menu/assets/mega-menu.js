var taMegaMenu;

(function ($, _) {
    'use strict';

    var api,
        wp = window.wp;

    api = taMegaMenu = {
        init: function () {
            api.$body = $('body');
            api.$modal = $('#tamm-settings');
            api.itemData = {};
            api.templates = {
                menus: wp.template('tamm-menus'),
                title: wp.template('tamm-title'),
                mega: wp.template('tamm-mega'),
                background: wp.template('tamm-background'),
                icon: wp.template('tamm-icon'),
                content: wp.template('tamm-content'),
                general: wp.template('tamm-general'),
                general_2: wp.template('tamm-general_2')
            };

            api.frame = wp.media({
                library: {
                    type: 'image'
                }
            });

            this.initActions();
        },

        initActions: function () {
            api.$body
                .on('click', '.opensettings', this.openModal)
                .on('click', '.tamm-modal-backdrop, .tamm-modal-close, .tamm-button-cancel', this.closeModal);

            api.$modal
                .on('click', '.tamm-menu a', this.switchPanel)
                .on('click', '.tamm-column-handle', this.resizeMegaColumn)
                .on('click', '.tamm-button-save', this.saveChanges)
                .on('click', '.tamm-mega-fullwidth input', this.toggleSetting)
                .on('change', '.tamm-panel-mega-width-field select', this.toggleField)
                .on('change', '.tamm-panel-icon_type select', this.toggleField);
        },

        openModal: function () {
            api.getItemData(this);

            api.$modal.show();
            api.$body.addClass('modal-open');
            api.render();

            return false;
        },

        closeModal: function () {
            api.$modal.hide().find('.tamm-content').html('');
            api.$body.removeClass('modal-open');
            return false;
        },

        switchPanel: function (e) {
            e.preventDefault();

            var $el = $(this),
                panel = $el.data('panel');

            $el.addClass('active').siblings('.active').removeClass('active');
            api.openSettings(panel);
        },

        render: function () {
            // Render menu
            api.$modal.find('.tamm-frame-menu .tamm-menu').html(api.templates.menus(api.itemData));

            var $activeMenu = api.$modal.find('.tamm-menu a.active');

            // Render content
            this.openSettings($activeMenu.data('panel'));
        },

        openSettings: function (panel) {
            var $content = api.$modal.find('.tamm-frame-content .tamm-content'),
                $panel = $content.children('#tamm-panel-' + panel);

            if ($panel.length) {
                $panel.addClass('active').siblings().removeClass('active');
            } else {
                $content.append(api.templates[panel](api.itemData));
                $content.children('#tamm-panel-' + panel).addClass('active').siblings().removeClass('active');

                if ('mega' === panel) {
                    api.initMegaColumns();
                }
                if ('background' === panel) {
                    api.initBackgroundFields();
                }
                if ('icon' === panel) {
                    api.initIconFields();
                    api.initBackgroundFields();
                }
            }

            // Render title
            var title = api.$modal.find('.tamm-frame-menu .tamm-menu a[data-panel=' + panel + ']').data('title');
            api.$modal.find('.tamm-frame-title').html(api.templates.title({title: title}));
        },

        toggleField: function () {
            var field = $(this).closest('.setting-field');

            field.siblings().hide();
            field.siblings('.setting-field-' + $(this).val() + '').show();

        },

        toggleSetting: function () {
            var field = $(this).closest('.mega-setting');

            field.siblings('.mega-setting-' + $(this).attr('data-name') + '').toggle();

        },


        resizeMegaColumn: function (e) {
            e.preventDefault();

            var $el = $(this),
                $column = $el.closest('.tamm-submenu-column'),
                width = $column.data('width'),
                current = api.getWidthData( width ),
                next;

            if ( ! current ) {
				return;
			}

			if ( $el.hasClass( 'tamm-resizable-w' ) ) {
				next = current.increase ? current.increase : current;
			} else {
				next = current.decrease ? current.decrease : widthData;
			}

            $column[0].style.width = next.width;
            $column.data('width', next.width);
            $column.find( '.tamm-column-width-label' ).text( next.label );
            $column.find('.menu-item-depth-0 .menu-item-width').val(next.width ).trigger( 'change' );
        },

        getWidthData: function( width ) {
			var steps = [
				{width: '12.50%', label: '1/8'},
				{width: '20.00%', label: '1/5'},
				{width: '25.00%', label: '1/4'},
				{width: '33.33%', label: '1/3'},
				{width: '37.50%', label: '3/8'},
				{width: '40.00%', label: '2/5'},
				{width: '50.00%', label: '1/2'},
				{width: '60.00%', label: '3/5'},
				{width: '62.50%', label: '5/8'},
				{width: '66.66%', label: '2/3'},
				{width: '75.00%', label: '3/4'},
				{width: '80.00%', label: '4/5'},
				{width: '87.50%', label: '7/8'},
				{width: '100.00%', label: '1/1'}
			];

			var index = _.findIndex( steps, function( data ) { return data.width === width; } );

			if ( index === 'undefined' ) {
				return false;
			}

			var data = {
				index: index,
				width: steps[index].width,
				label: steps[index].label
			};

			if ( index > 0 ) {
				data.decrease = {
					index: index - 1,
					width: steps[index - 1].width,
					label: steps[index - 1].label
				};
			}

			if ( index < steps.length - 1 ) {
				data.increase = {
					index: index + 1,
					width: steps[index + 1].width,
					label: steps[index + 1].label
				};
			}

			return data;
		},

        initMegaColumns: function () {
            var $columns = api.$modal.find('#tamm-panel-mega .tamm-submenu-column'),
                defaultWidth = '25.00%';

            if (!$columns.length) {
                return;
            }

            // Support maximum 4 columns
            if ($columns.length < 4) {
                defaultWidth = String((100 / $columns.length).toFixed(2)) + '%';
            }

            _.each( $columns, function ( column ) {
				var width = column.dataset.width;

				if ( ! parseInt( width ) ) {
					width = defaultWidth;
				}

				var widthData = api.getWidthData( width );

				column.style.width = widthData.width;
				column.dataset.width = widthData.width;
				$( column ).find( '.menu-item-depth-0 .menu-item-width' ).val( width );
				$( column ).find( '.tamm-column-width-label' ).text( widthData.label );
			} );
        },

        initBackgroundFields: function () {
            api.$modal.find('.background-color-picker').wpColorPicker();

            // Background image
            api.$modal.on('click', '.background-image .upload-button', function (e) {
                e.preventDefault();

                var $el = $(this);

                // Remove all attached 'select' event
                api.frame.off('select');

                // Update inputs when select image
                api.frame.on('select', function () {
                    // Update input value for single image selection
                    var url = api.frame.state().get('selection').first().toJSON().url;

                    $el.siblings('.background-image-preview').html('<img src="' + url + '">');
                    $el.siblings('input').val(url);
                    $el.siblings('.remove-button').removeClass('hidden');
                });

                api.frame.open();
            }).on('click', '.background-image .remove-button', function (e) {
                e.preventDefault();

                var $el = $(this);

                $el.siblings('.background-image-preview').html('');
                $el.siblings('input').val('');
                $el.addClass('hidden');
            });

            // Background position
            api.$modal.on('change', '.background-position select', function () {
                var $el = $(this);

                if ('custom' == $el.val()) {
                    $el.next('input').removeClass('hidden');
                } else {
                    $el.next('input').addClass('hidden');
                }
            });
        },

        initIconFields: function () {
            var $input = api.$modal.find('#tamm-icon-input'),
                $preview = api.$modal.find('#tamm-selected-icon');

            api.$modal.find('.tamm-icon-color-picker').wpColorPicker();

            $preview.on('click', '.tamm-selected-icon__inner', function () {
                $(this).children().remove();
                $input.val('');
            });


        },

        getItemData: function (menuItem) {
            var $menuItem = $(menuItem).closest('li.menu-item'),
                $menuData = $menuItem.find('.tamm-data'),
                $menuDataIconSVG = $menuItem.find('.tamm-data-icons'),
                children = $menuItem.childMenuItems();

            api.itemData = {
                depth: $menuItem.menuItemDepth(),
                megaData: {
                    mega: $menuData.data('mega'),
                    mega_fullwidth: $menuData.data('mega_fullwidth'),
                    mega_width: $menuData.data('mega_width'),
                    mega_align: $menuData.data('mega_align'),
                    width: $menuData.data('width'),
                    background: $menuData.data('background'),
                    icon_type: $menuData.data('icon_type'),
                    icon_image: $menuData.data('icon_image'),
                    icon_svg: $menuDataIconSVG.html(),
                    icon_text: $menuData.data('icon_text'),
                    icon_color: $menuData.data('icon_color'),
                    icon_text_color: $menuData.data('icon_text_color'),
                    hideText: $menuData.data('hide-text'),
                    isLabel: $menuData.data('is-label'),
                    content: $menuData.html()
                },
                data: $menuItem.getItemData(),
                children: [],
                originalElement: $menuItem.get(0)
            };

            if (!_.isEmpty(children)) {
                _.each(children, function (item) {
                    var $item = $(item),
                        $itemData = $item.find('.tamm-data'),
                        $itemDataIconSVG = $menuItem.find('.tamm-data-icons'),
                        depth = $item.menuItemDepth();

                    api.itemData.children.push({
                        depth: depth,
                        subDepth: depth - api.itemData.depth - 1,
                        data: $item.getItemData(),
                        megaData: {
                            mega: $itemData.data('mega'),
                            mega_fullwidth: $itemData.data('mega_fullwidth'),
                            mega_width: $itemData.data('mega_width'),
                            mega_align: $itemData.data('mega_align'),
                            width: $itemData.data('width'),
                            background: $itemData.data('background'),
                            icon: $itemData.data('icon'),
                            icon_type: $itemData.data('icon_type'),
                            icon_image: $itemData.data('icon_image'),
                            icon_svg: $itemDataIconSVG.html(),
                            icon_text: $itemData.data('icon_text'),
                            icon_color: $itemData.data('icon_color'),
                            icon_text_color: $itemData.data('icon_text_color'),
                            hideText: $itemData.data('hide-text'),
                            isLabel: $itemData.data('is-label'),
                            content: $itemData.html()
                        },
                        originalElement: item
                    });
                });
            }

        },

        setItemData: function (item, data, depth) {
            if (!_.has(data, 'mega')) {
                data.mega = false;
            }

            if (!_.has(data, 'mega_fullwidth')) {
                data.mega_fullwidth = false;
            }

            if (depth == 0) {
                if (!_.has(data, 'hideText')) {
                    data.hideText = false;
                }

                if (!_.has(data, 'isLabel')) {
                    data.isLabel = false;
                }
            }

            var $dataHolder = $(item).find('.tamm-data');

            if (_.has(data, 'content')) {
                $dataHolder.html(data.content);
                delete data.content;
            }

            $dataHolder.data(data);

            if (_.has(data, 'icon_svg')) {
                $dataHolder = $(item).find('.tamm-data-icons');
                $dataHolder.html(data.icon_svg);
                delete data.icon_svg;
            }

        },

        getFieldName: function (name, id) {
            name = name.split('.');
            name = '[' + name.join('][') + ']';

            return 'menu-item[' + id + ']' + name;
        },

        saveChanges: function () {

            if (api.$modal.find('.tamm-content .tamm-panel-icon_type select').val() !== 'image') {
                api.$modal.find('.tamm-content .tamm-panel-icon_image').val('');
            }

            if (api.$modal.find('.tamm-content .tamm-panel-icon_type select').val() !== 'text') {
                api.$modal.find('.tamm-content .tamm-panel-icon_text').val('');
            }

            if (api.$modal.find('.tamm-content .tamm-panel-icon_type select').val() !== 'svg') {
                api.$modal.find('.tamm-content .tamm-panel-icon_svg').val('');
            }

            var data = api.$modal.find('.tamm-content :input, .tamm-content .mega-data-icon_svg').serialize(),
                $spinner = api.$modal.find('.tamm-toolbar .spinner');


            $spinner.addClass('is-active');

            $.post(ajaxurl, {
                action: 'tamm_save_menu_item_data',
                data: data
            }, function (res) {
                if (!res.success) {
                    return;
                }

                var data = res.data['menu-item'];

                // Update parent menu item
                if (_.has(data, api.itemData.data['menu-item-db-id'])) {
                    api.setItemData(api.itemData.originalElement, data[api.itemData.data['menu-item-db-id']], 0);
                }

                _.each(api.itemData.children, function (menuItem) {
                    if (!_.has(data, menuItem.data['menu-item-db-id'])) {
                        return;
                    }

                    api.setItemData(menuItem.originalElement, data[menuItem.data['menu-item-db-id']], 1);
                });

                $spinner.removeClass('is-active');
                api.closeModal();
            });
        }
    };

    $(function () {
        taMegaMenu.init();
    });
})(jQuery, _);