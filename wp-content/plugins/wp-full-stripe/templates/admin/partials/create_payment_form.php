<?php
/**
 * Created by PhpStorm.
 * User: tnagy
 * Date: 2017.02.23.
 * Time: 14:57
 */
?>
<h2 id="create-payment-form-tabs" class="nav-tab-wrapper wpfs-admin-form-tabs">
	<a href="#create-payment-form-tab-payment" class="nav-tab"><?php esc_html_e( 'Payment', 'wp-full-stripe-admin' ); ?></a>
	<a href="#create-payment-form-tab-appearance" class="nav-tab"><?php esc_html_e( 'Appearance', 'wp-full-stripe-admin' ); ?></a>
	<a href="#create-payment-form-tab-custom-fields" class="nav-tab"><?php esc_html_e( 'Custom Fields', 'wp-full-stripe-admin' ); ?></a>
	<a href="#create-payment-form-tab-actions-after-payment" class="nav-tab"><?php esc_html_e( 'Actions after payment', 'wp-full-stripe-admin' ); ?></a>
</h2>
<form class="form-horizontal wpfs-admin-form" action="" method="POST" id="create-payment-form">
	<p class="tips"></p>
	<input type="hidden" name="action" value="wp_full_stripe_create_payment_form">
	<div id="create-payment-form-tab-payment" class="wpfs-tab-content">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Form Type:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td><?php esc_html_e( 'Inline payment form', 'wp-full-stripe-admin' ); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Form Name:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<input type="text" class="regular-text" name="form_name" id="form_name" maxlength="<?php echo $form_data::NAME_LENGTH; ?>">

					<p class="description"><?php esc_html_e( 'This name will be used to identify this form in the shortcode i.e. [fullstripe_form name="formName" type="inline_payment"]', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Payment Type: ', 'wp-full-stripe-admin' ); ?></label>
				</th>
				<td>
					<label class="radio inline">
						<input type="radio" name="form_custom" id="set_specific_amount" value="specified_amount" checked="checked">
						<?php esc_html_e( 'Set Amount', 'wp-full-stripe-admin' ); ?>
					</label>
					<label class="radio inline">
						<input type="radio" name="form_custom" id="set_amount_list" value="list_of_amounts">
						<?php esc_html_e( 'Select Amount from List', 'wp-full-stripe-admin' ); ?>
					</label>
					<label class="radio inline">
						<input type="radio" name="form_custom" id="set_custom_amount" value="custom_amount">
						<?php esc_html_e( 'Custom Amount', 'wp-full-stripe-admin' ); ?>
					</label>

					<p class="description"><?php esc_html_e( 'Choose to set a specific amount or a list of amounts for this form, or allow customers to set custom amounts.', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Charge Type: ', 'wp-full-stripe-admin' ); ?></label>
				</th>
				<td>
					<label class="radio inline">
						<input type="radio" name="form_charge_type" value="<?php echo MM_WPFS::CHARGE_TYPE_IMMEDIATE; ?>" checked="checked">
						<?php esc_html_e( 'Immediate', 'wp-full-stripe-admin' ); ?>
					</label>
					<label class="radio inline">
						<input type="radio" name="form_charge_type" value="<?php echo MM_WPFS::CHARGE_TYPE_AUTHORIZE_AND_CAPTURE; ?>">
						<?php esc_html_e( 'Authorize and Capture', 'wp-full-stripe-admin' ); ?>
					</label>

					<p class="description"><?php esc_html_e( 'Choose whether you want to charge immediately, or authorize the payment now, and capture it later.', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
			<tr valign="top" id="payment_currency_row">
				<th scope="row">
					<label class="control-label" for="currency"><?php esc_html_e( "Payment Currency: ", 'wp-full-stripe-admin' ); ?></label>
				</th>
				<td>
					<div class="ui-widget">
						<select id="currency" name="form_currency">
							<option value=""><?php esc_attr_e( 'Select from the list or start typing', 'wp-full-stripe-admin' ); ?></option>
							<?php
							foreach ( MM_WPFS_Currencies::get_available_currencies() as $currency_key => $currency_obj ) {
								$currency_array = MM_WPFS_Currencies::get_currency_for( $currency_key );
								$option         = '<option value="' . $currency_key . '"';
								$option .= ' data-currency-symbol="' . $currency_array['symbol'] . '"';
								$option .= ' data-zero-decimal-support="' . ( $currency_array['zeroDecimalSupport'] == true ? 'true' : 'false' ) . '"';
								if ( MM_WPFS::CURRENCY_USD === $currency_key ) {
									$option .= ' selected="selected"';
								}
								$option .= '>';
								$option .= $currency_obj['name'] . ' (' . $currency_obj['code'] . ')';
								$option .= '</option>';
								echo $option;
							}
							?>
						</select>
					</div>
				</td>
			</tr>
			<tr valign="top" id="payment_amount_row">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Payment Amount:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<input type="text" class="regular-text" name="form_amount" id="form_amount"/>

					<p class="description"><?php esc_html_e( 'The amount this form will charge your customer, in the smallest unit for the currency. i.e. for $10.00 enter 1000, for ¥10 enter 10.', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
			<tr valign="top" id="payment_amount_list_row" style="display: none;">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Payment Amount Options:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<a href="#" class="button button-primary" id="add_payment_amount_button"><?php esc_html_e( 'Add', 'wp-full-stripe-admin' ); ?></a>
					<input type="text" id="payment_amount_value" placeholder="<?php esc_attr_e( 'Amount', 'wp-full-stripe-admin' ); ?>" maxlength="<?php echo $form_data::PAYMENT_AMOUNT_LENGTH; ?>"><input type="text" id="payment_amount_description" placeholder="<?php esc_attr_e( 'Description', 'wp-full-stripe-admin' ); ?>" maxlength="<?php echo $form_data::PAYMENT_AMOUNT_DESCRIPTION_LENGTH; ?>"><br>
					<ul id="payment_amount_list"></ul>
					<input type="hidden" name="payment_amount_values">
					<input type="hidden" name="payment_amount_descriptions">

					<p class="description"><?php esc_html_e( 'The amount in the smallest unit for the currency. i.e. for $10.00 enter 1000, for ¥10 enter 10. The description will be displayed in the dropdown for the amount. Use the {amount} placeholder to include the amount value. You can use drag\'n\'drop to reorder the payment amounts.', 'wp-full-stripe-admin' ); ?></p>
					<label class="checkbox inline"><input type="checkbox" name="allow_custom_payment_amount" id="allow_custom_payment_amount" value="1"><?php esc_html_e( 'Allow Custom Amount to Be Entered?', 'wp-full-stripe-admin' ); ?>
					</label>
				</td>
			</tr>
			<tr valign="top" id="stripe_description_row">
				<th scope="row">
					<label class="control-label">
						<?php esc_html_e( 'Description: ', 'wp-full-stripe-admin' ); ?>
					</label>
				</th>
				<td>
					<textarea rows="3" class="large-text code" name="stripe_description"><?php echo esc_html( MM_WPFS_Utils::create_default_payment_stripe_description() ); ?></textarea>
					<p class="description"><?php printf( __( 'It appears in the "Payment details" section of the payment on the Stripe dashboard. You can use placeholders, see the <a target="_blank" href="%s">Help page</a> for more options.', 'wp-full-stripe-admin' ), admin_url( "admin.php?page=fullstripe-help#receipt-tokens" ) ); ?> </p>
				</td>
			</tr>
		</table>
	</div>
	<div id="create-payment-form-tab-appearance" class="wpfs-tab-content">
		<table class="form-table">
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
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Payment Button Text:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<input type="text" class="regular-text" name="form_button_text" id="form_button_text" value="<?php esc_attr_e( 'Make Payment', 'wp-full-stripe-admin' ); ?>" maxlength="<?php echo $form_data::BUTTON_TITLE_LENGTH; ?>">

					<p class="description"><?php esc_html_e( 'The text on the payment button.', 'wp-full-stripe-admin' ); ?></p>
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
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Collect Billing Address?', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<label class="radio inline">
						<input type="radio" name="form_show_address_input" id="hide_address_input" value="0" checked="checked">
						<?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
					</label>
					<label class="radio inline">
						<input type="radio" name="form_show_address_input" id="show_address_input" value="1">
						<?php esc_html_e( 'Yes', 'wp-full-stripe-admin' ); ?>
					</label>

					<p class="description"><?php esc_html_e( 'Should this payment form also ask for the customers\' billing address?', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
			<tr id="defaultBillingCountryRow" valign="top" style="display: none;">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Default Billing Country:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<select name="form_default_billing_country" class="fullstripe-form-input input-xlarge">
						<?php
						foreach ( MM_WPFS_Countries::get_available_countries() as $countryKey => $countryObject ) {
							$option = '<option';
							$option .= " value=\"{$countryKey}\"";
							if ( $countryKey == MM_WPFS::DEFAULT_BILLING_COUNTRY_INITIAL_VALUE ) {
								$option .= ' selected="selected"';
							}
							$option .= '>';
							$option .= MM_WPFS_Admin::translateLabelAdmin($countryObject['name']);
							$option .= '</option>';
							echo $option;
						}
						?>
					</select>
					<p class="description"><?php esc_html_e( "It's the selected country when the form is rendered for the first time.", 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Collect Shipping Address?', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<label class="radio inline">
						<input type="radio" name="form_show_shipping_address_input" id="hide_shipping_address_input" value="0" checked="checked">
						<?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
					</label>
					<label class="radio inline">
						<input type="radio" name="form_show_shipping_address_input" id="show_shipping_address_input" value="1">
						<?php esc_html_e( 'Yes', 'wp-full-stripe-admin' ); ?>
					</label>

					<p class="description"><?php esc_html_e( 'Should this payment form also ask for the customers\' shipping address?', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
            <tr valign="top">
                <th scope="row">
                    <label class="control-label" for=""><?php esc_html_e( "Card Input Field Language: ", 'wp-full-stripe-admin' ); ?></label>
                </th>
                <td>
                    <select name="form_preferred_language">
                        <option value="<?php echo MM_WPFS::PREFERRED_LANGUAGE_AUTO; ?>"><?php esc_html_e( 'Auto', 'wp-full-stripe-admin' ); ?></option>
                        <?php
                        foreach ( MM_WPFS::get_available_stripe_elements_languages() as $language ) {
                            $option = '<option value="' . $language['value'] . '"';
                            $option .= '>';
                            $option .= $language['name'];
                            $option .= '</option>';
                            echo $option;
                        }
                        ?>
                    </select>

                    <p class="description"><?php esc_html_e( "Display the card info field in the selected language. Use 'Auto' to determine the language from the locale sent by the customer's browser.", 'wp-full-stripe-admin' ); ?></p>
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
	</div>
	<div id="create-payment-form-tab-custom-fields" class="wpfs-tab-content">
		<?php include('create_payment_form_tab_custom_fields.php'); ?>
	</div>
	<div id="create-payment-form-tab-actions-after-payment" class="wpfs-tab-content">
		<?php include('create_payment_form_tab_actions_after_payment.php'); ?>
	</div>
	<p class="submit">
		<button class="button button-primary" type="submit"><?php esc_html_e( 'Create Form', 'wp-full-stripe-admin' ); ?></button>
		<a href="<?php echo admin_url( 'admin.php?page=fullstripe-payments&tab=forms' ); ?>" class="button"><?php esc_html_e( 'Cancel', 'wp-full-stripe-admin' ); ?></a>
		<img src="<?php echo MM_WPFS_Assets::images( 'loader.gif' ); ?>" alt="<?php esc_attr_e( 'Loading...', 'wp-full-stripe-admin' ); ?>" class="showLoading"/>
	</p>
</form>
