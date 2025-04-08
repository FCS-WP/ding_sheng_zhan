<# var itemId = data.data['menu-item-db-id']; #>
<div id="tamm-panel-background" class="tamm-panel-background tamm-panel">
    <p class="background-image">
        <label><?php esc_html_e( 'Background Image', 'farmart-addons' ) ?></label><br>
        <span class="background-image-preview">
			<# if ( data.megaData.background.image ) { #>
				<img src="{{ data.megaData.background.image }}">
			<# } #>
		</span>

        <button type="button"
                class="button remove-button {{ ! data.megaData.background.image ? 'hidden' : '' }}"><?php esc_html_e( 'Remove', 'farmart-addons' ) ?></button>
        <button type="button" class="button upload-button"
                id="background_image-button"><?php esc_html_e( 'Select Image', 'farmart-addons' ) ?></button>

        <input type="hidden" name="{{ taMegaMenu.getFieldName( 'background.image', itemId ) }}"
               value="{{ data.megaData.background.image }}">
    </p>

    <p class="background-color">
        <label><?php esc_html_e( 'Background Color', 'farmart-addons' ) ?></label><br>
        <input type="text" class="background-color-picker"
               name="{{ taMegaMenu.getFieldName( 'background.color', itemId ) }}"
               value="{{ data.megaData.background.color }}">
    </p>

    <p class="background-repeat">
        <label><?php esc_html_e( 'Background Repeat', 'farmart-addons' ) ?></label><br>
        <select name="{{ taMegaMenu.getFieldName( 'background.repeat', itemId ) }}">
            <option value="no-repeat" {{
            'no-repeat' == data.megaData.background.repeat ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'No Repeat', 'farmart-addons' ) ?></option>
            <option value="repeat"
            {{ 'repeat' == data.megaData.background.repeat ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Repeat', 'farmart-addons' ) ?></option>
            <option value="repeat-x"
            {{ 'repeat-x' == data.megaData.background.repeat ? 'selected="selected"' : ''
           }}><?php esc_html_e( 'Repeat Horizontally', 'farmart-addons' ) ?></option>
            <option value="repeat-y"
            {{ 'repeat-y' == data.megaData.background.repeat ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Repeat Vertically', 'farmart-addons' ) ?></option>
        </select>
    </p>

    <p class="background-position background-position-x">
        <label><?php esc_html_e( 'Background Position', 'farmart-addons' ) ?></label><br>

        <select name="{{ taMegaMenu.getFieldName( 'background.position.x', itemId ) }}">
            <option value="left"
            {{ 'left' == data.megaData.background.position.x ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Left', 'farmart-addons' ) ?></option>
            <option value="center"
            {{ 'center' == data.megaData.background.position.x ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Center', 'farmart-addons' ) ?></option>
            <option value="right"
           {{ 'right' == data.megaData.background.position.x ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Right', 'farmart-addons' ) ?></option>
            <option value="custom"
            {{ 'custom' == data.megaData.background.position.x ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Custom', 'farmart-addons' ) ?></option>
        </select>

        <input
                type="text"
                name="{{ taMegaMenu.getFieldName( 'background.position.custom.x', itemId ) }}"
                value="{{ data.megaData.background.position.custom.x }}"
                class="{{ 'custom' != data.megaData.background.position.x ? 'hidden' : '' }}">
    </p>

    <p class="background-position background-position-y">
        <select name="{{ taMegaMenu.getFieldName( 'background.position.y', itemId ) }}">
            <option value="top"
            {{ 'top' == data.megaData.background.position.y ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Top', 'farmart-addons' ) ?></option>
            <option value="center"
            {{ 'center' == data.megaData.background.position.y ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Middle', 'farmart-addons' ) ?></option>
            <option value="bottom"
            {{ 'bottom' == data.megaData.background.position.y ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Bottom', 'farmart-addons' ) ?></option>
            <option value="custom"
            {{ 'custom' == data.megaData.background.position.y ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Custom', 'farmart-addons' ) ?></option>
        </select>
        <input
                type="text"
                name="{{ taMegaMenu.getFieldName( 'background.position.custom.y', itemId ) }}"
                value="{{ data.megaData.background.position.custom.y }}"
                class="{{ 'custom' != data.megaData.background.position.y ? 'hidden' : '' }}">
    </p>

    <p class="background-attachment">
        <label><?php esc_html_e( 'Background Attachment', 'farmart-addons' ) ?></label><br>
        <select name="{{ taMegaMenu.getFieldName( 'background.attachment', itemId ) }}">
            <option value="scroll"
            {{ 'scroll' == data.megaData.background.attachment ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Scroll', 'farmart-addons' ) ?></option>
            <option value="fixed"
            {{ 'fixed' == data.megaData.background.attachment ? 'selected="selected"' : ''
            }}><?php esc_html_e( 'Fixed', 'farmart-addons' ) ?></option>
        </select>
    </p>
</div>