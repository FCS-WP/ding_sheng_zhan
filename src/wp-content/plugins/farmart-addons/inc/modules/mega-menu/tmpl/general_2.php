<?php
global $wp_widget_factory;
?>
<div id="tamm-panel-general_2" class="tamm-panel-general_2 tamm-panel">
    <div class="mr-tamm-panel-box">
        <p>
			<label>
				<input type="checkbox" name="{{ taMegaMenu.getFieldName( 'hideText', data.data['menu-item-db-id'] ) }}" value="1" {{ data.megaData.hideText ? 'checked="checked"' : '' }} >
				<?php esc_html_e( 'Hide Text', 'farmart-addons' ) ?>
			</label>
		</p>
        <p>
            <label>
                <input type="checkbox" name="{{ taMegaMenu.getFieldName( 'isLabel', data.data['menu-item-db-id'] ) }}"
                       value="1" {{ data.megaData.isLabel ? 'checked="checked"' : '' }} >
				<?php esc_html_e( 'Is Label', 'farmart-addons' ) ?>
            </label>
        </p>
    </div>
</div>