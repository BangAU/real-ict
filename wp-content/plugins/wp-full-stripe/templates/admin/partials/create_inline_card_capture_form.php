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
	<input type="hidden" name="action" value="wp_full_stripe_create_inline_card_capture_form">
	<div id="create-payment-form-tab-payment" class="wpfs-tab-content">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Form Type:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td><?php esc_html_e( 'Inline save card form', 'wp-full-stripe-admin' ); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Form Name:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<input type="text" class="regular-text" name="form_name" id="form_name" maxlength="<?php echo $form_data::NAME_LENGTH; ?>">

					<p class="description"><?php esc_html_e( 'This name will be used to identify this form in the shortcode i.e. [fullstripe_form name="formName" type="inline_save_card"]', 'wp-full-stripe-admin' ); ?></p>
				</td>
			</tr>
            <tr valign="top" id="stripe_description_row">
                <th scope="row">
                    <label class="control-label">
                        <?php esc_html_e( 'Description: ', 'wp-full-stripe-admin' ); ?>
                    </label>
                </th>
                <td>
                    <textarea rows="3" class="large-text code" name="stripe_description"><?php echo esc_html( MM_WPFS_Utils::createDefaultCardSavedDescription() ); ?></textarea>
                    <p class="description"><?php printf( __( 'It appears in the customer\'s "Details" section on the Stripe dashboard. You can use placeholders, see the <a target="_blank" href="%s">Help page</a> for more options.', 'wp-full-stripe-admin' ), admin_url( "admin.php?page=fullstripe-help#receipt-tokens" ) ); ?> </p>
                </td>
            </tr>
            <input type="hidden" name="form_custom" value="card_capture">
		</table>
	</div>
	<div id="create-payment-form-tab-appearance" class="wpfs-tab-content">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label class="control-label"><?php esc_html_e( 'Payment Button Text:', 'wp-full-stripe-admin' ); ?> </label>
				</th>
				<td>
					<input type="text" class="regular-text" name="form_button_text" id="form_button_text" value="<?php esc_attr_e( 'Save Card Details', 'wp-full-stripe-admin' ); ?>" maxlength="<?php echo $form_data::BUTTON_TITLE_LENGTH; ?>">

					<p class="description"><?php esc_html_e( 'The text on the payment button.', 'wp-full-stripe-admin' ); ?></p>
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
		<a href="<?php echo admin_url( 'admin.php?page=fullstripe-saved-cards&tab=forms' ); ?>" class="button"><?php esc_html_e( 'Cancel', 'wp-full-stripe-admin' ); ?></a>
		<img src="<?php echo MM_WPFS_Assets::images( 'loader.gif' ); ?>" alt="<?php esc_attr_e( 'Loading...', 'wp-full-stripe-admin' ); ?>" class="showLoading"/>
	</p>
</form>
