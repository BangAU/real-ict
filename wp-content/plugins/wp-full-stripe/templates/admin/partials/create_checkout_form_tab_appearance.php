<?php
/**
 * Created by PhpStorm.
 * User: tnagy
 * Date: 2017.03.29.
 * Time: 14:01
 */
if ( ! isset( $open_form_button_text_value ) ) {
	$open_form_button_text_value = __( 'Pay With Card', 'wp-full-stripe-admin' );
}
if ( ! isset( $button_title ) ) {
	$button_title = __( 'Pay {{amount}}', 'wp-full-stripe-admin' );
}
?>
<table class="form-table">
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Product Name:', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<input type="text" class="regular-text" name="prod_desc" id="prod_desc" maxlength="<?php echo $form_data::PRODUCT_DESCRIPTION_LENGTH; ?>" value="<?php echo esc_attr( MM_WPFS_Admin_PopupFormModel::getDefaultProductDescription() ); ?>">

			<p class="description"><?php esc_html_e( 'The name of the product or service sold using this form. When using "Select Amount from List", the selected amount\'s description will replace this value.', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Product Description:', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<input type="text" class="regular-text" name="company_name" id="company_name" maxlength="<?php echo $form_data::COMPANY_NAME_LENGTH; ?>">

			<p class="description"><?php esc_html_e( 'A short description (one line) about the product or service sold using this form. When using "Select Amount from List", you may provide your Company\'s name here.', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Product Image', 'wp-full-stripe-admin' ); ?></label>
		</th>
		<td>
			<input id="form_checkout_image" type="text" name="form_checkout_image" maxlength="<?php echo $form_data::IMAGE_LENGTH; ?>" placeholder="<?php esc_attr_e( 'Enter image URL', 'wp-full-stripe-admin' ); ?>">
			<button id="upload_image_button" class="button" type="button" value="<?php esc_attr_e( 'Upload Image', 'wp-full-stripe-admin' ); ?>">
				<?php esc_html_e( 'Upload Image', 'wp-full-stripe-admin' ); ?>
			</button>
			<p class="description"><?php esc_html_e( 'A square image of your brand or product which is shown on the form. Min size 128px x 128px.', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Open Form Button Text:', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<input type="text" class="regular-text" name="open_form_button_text" id="open_form_button_text" value="<?php echo esc_attr( $open_form_button_text_value ); ?>" maxlength="<?php echo $form_data::OPEN_BUTTON_TITLE_LENGTH; ?>">

			<p class="description"><?php esc_html_e( 'The text on the button used to pop open this form.', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
	<tr valign="top" id="include_amount_on_button_row">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Include Amount on Button?', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<label class="radio inline">
				<input type="radio" name="form_button_amount" id="hide_button_amount" value="0">
				<?php esc_html_e( 'Hide', 'wp-full-stripe-admin' ); ?>
			</label>
			<label class="radio inline">
				<input type="radio" name="form_button_amount" id="show_button_amount" value="1" checked="checked">
				<?php esc_html_e( 'Show', 'wp-full-stripe-admin' ); ?>
			</label>

			<p class="description"><?php esc_html_e( 'For set amount forms, choose to show/hide the amount on the payment button.', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
	<?php if ( MM_WPFS::FORM_TYPE_POPUP_SAVE_CARD !== $form_type ): ?>
		<tr valign="top">
			<th scope="row">
				<label class="control-label"><?php esc_html_e( 'Amount Selector Style:', 'wp-full-stripe-admin' ); ?> </label>
			</th>
			<td>
				<select class="regular-text" name="amount_selector_style" id="amount_selector_style">
					<option value="dropdown"><?php esc_html_e( 'Product selector dropdown', 'wp-full-stripe-admin' ); ?></option>
					<option value="radio-buttons"><?php esc_html_e( 'List of products', 'wp-full-stripe-admin' ); ?></option>
					<option value="button-group"><?php esc_html_e( 'Donation button group', 'wp-full-stripe-admin' ); ?></option>
				</select>

				<p class="description"><?php esc_html_e( 'Choose how you\'d like the amount(s) of the form to look.', 'wp-full-stripe-admin' ); ?></p>
			</td>
		</tr>
	<?php endif; ?>
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Collect Billing Address?', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<label class="radio inline">
				<input type="radio" name="form_show_address_input" id="hide_address_input" value="0" checked="checked">
				<?php esc_html_e( 'Hide', 'wp-full-stripe-admin' ); ?>
			</label>
			<label class="radio inline">
				<input type="radio" name="form_show_address_input" id="show_address_input" value="1">
				<?php esc_html_e( 'Show', 'wp-full-stripe-admin' ); ?>
			</label>

			<p class="description"><?php esc_html_e( 'Should this payment form also ask for the customers billing address?', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label class="control-label" for=""><?php esc_html_e( "Checkout Form Language: ", 'wp-full-stripe-admin' ); ?></label>
		</th>
		<td>
			<select name="form_preferred_language">
				<option value="<?php echo MM_WPFS::PREFERRED_LANGUAGE_AUTO; ?>"><?php esc_html_e( 'Auto', 'wp-full-stripe-admin' ); ?></option>
				<?php
				foreach ( MM_WPFS::get_available_checkout_languages() as $language ) {
					$option = '<option value="' . $language['value'] . '"';
					$option .= '>';
					$option .= $language['name'];
					$option .= '</option>';
					echo $option;
				}
				?>
			</select>

			<p class="description"><?php esc_html_e( "Display the checkout form in the selected language. Use 'Auto' to determine the language from the locale sent by the customer's browser.", 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
    <tr valign="top">
        <th scope="row">
            <label class="control-label"><?php esc_html_e( 'Format decimals with:', 'wp-full-stripe-admin' ); ?></label>
        </th>
        <td>
            <label class="checkbox">
                <input type="radio" name="decimal_separator" id="decimal_separator_dot" value="<?php echo MM_WPFS::DECIMAL_SEPARATOR_SYMBOL_DOT; ?>" checked>
                <?php esc_html_e( '$10.99 (dot)', 'wp-full-stripe-admin' ); ?>
            </label>
            <label class="checkbox">
                <input type="radio" name="decimal_separator" id="decimal_separator_comma" value="<?php echo MM_WPFS::DECIMAL_SEPARATOR_SYMBOL_COMMA; ?>">
                <?php esc_html_e( '$10,99 (comma)', 'wp-full-stripe-admin' ); ?>
            </label>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label class="control-label"><?php esc_html_e( 'Use currency symbol or code?', 'wp-full-stripe-admin' ); ?></label>
        </th>
        <td>
            <label class="checkbox">
                <input type="radio" name="show_currency_symbol_instead_of_code" id="use_currency_symbol" value="1" checked>
                <?php esc_html_e( '$10.99 (symbol)', 'wp-full-stripe-admin' ); ?>
            </label>
            <label class="checkbox">
                <input type="radio" name="show_currency_symbol_instead_of_code" id="use_currency_code" value="0">
                <?php esc_html_e( 'USD 10.99 (code)', 'wp-full-stripe-admin' ); ?>
            </label>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label class="control-label"><?php esc_html_e( 'Put currency identifier on:', 'wp-full-stripe-admin' ); ?></label>
        </th>
        <td>
            <label class="checkbox">
                <input type="radio" name="show_currency_sign_at_first_position" id="put_currency_identifier_to_the_left" value="1" checked>
                <?php esc_html_e( '€10.99 (left)', 'wp-full-stripe-admin' ); ?>
            </label>
            <label class="checkbox">
                <input type="radio" name="show_currency_sign_at_first_position" id="put_currency_identifier_to_the_right" value="0">
                <?php esc_html_e( '10.99€ (right)', 'wp-full-stripe-admin' ); ?>
            </label>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label class="control-label"><?php esc_html_e( 'Insert space between amount and currency?', 'wp-full-stripe-admin' ); ?></label>
        </th>
        <td>
            <label class="checkbox">
                <input type="radio" name="put_whitespace_between_currency_and_amount" id="do_not_put_whitespace_between_currency_and_amount" value="0" checked>
                <?php esc_html_e( '$10.99 (no)', 'wp-full-stripe-admin' ); ?>
            </label>
            <label class="checkbox">
                <input type="radio" name="put_whitespace_between_currency_and_amount" id="put_whitespace_between_currency_and_amount" value="1">
                <?php esc_html_e( 'USD 10.99 (yes)', 'wp-full-stripe-admin' ); ?>
            </label>
        </td>
    </tr>
</table>
