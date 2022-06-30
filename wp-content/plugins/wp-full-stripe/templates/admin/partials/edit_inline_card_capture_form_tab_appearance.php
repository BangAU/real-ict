<?php
/**
 * Created by PhpStorm.
 * User: tnagy
 * Date: 2017.03.02.
 * Time: 16:47
 */

$form_id_css = MM_WPFS_Utils::generate_form_hash( MM_WPFS_Utils::getFormType( $form ), MM_WPFS_Utils::getFormId( $form ), $form->name );
?>
<table class="form-table">
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Form ID for Custom CSS:', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<p>
				<input class="wpfsadm-ro-clipboard" type="text" size="30" value="<?php echo( $form_id_css ); ?>" readonly>
				<a class="wpfsadm-copy-to-clipboard" data-form-id="<?php echo( $form_id_css ); ?>">Copy to clipboard</a>
			</p>
			<p class="description"><?php esc_html_e( 'Use this CSS selector to add custom styles to this form.', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Payment Button Text:', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<input type="text" class="regular-text" name="form_button_text" id="form_button_text" value="<?php echo $form->buttonTitle; ?>" maxlength="<?php echo $form_data::BUTTON_TITLE_LENGTH; ?>">

			<p class="description"><?php esc_html_e( 'The text on the payment button.', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Collect Billing Address?', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<label class="radio inline">
				<input type="radio" name="form_show_address_input" id="hide_address_input" value="0" <?php echo ( $form->showAddress == '0' ) ? 'checked' : '' ?> >
				<?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
			</label>
			<label class="radio inline">
				<input type="radio" name="form_show_address_input" id="show_address_input" value="1" <?php echo ( $form->showAddress == '1' ) ? 'checked' : '' ?> >
				<?php esc_html_e( 'Yes', 'wp-full-stripe-admin' ); ?>
			</label>

			<p class="description"><?php esc_html_e( 'Should this payment form also ask for the customers\' billing address?', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
	<tr id="defaultBillingCountryRow" valign="top" <?php echo ( $form->showAddress == '0' ) ? 'style="display: none;"' : '' ?>>
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Default Billing Country:', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<select name="form_default_billing_country" class="fullstripe-form-input input-xlarge">
				<?php
				if ( isset( $form->defaultBillingCountry ) ) {
					$selectedBillingCountry = $form->defaultBillingCountry;
				} else {
					$selectedBillingCountry = MM_WPFS::DEFAULT_BILLING_COUNTRY_INITIAL_VALUE;
				}
				foreach ( MM_WPFS_Countries::get_available_countries() as $countryKey => $countryObject ) {
					$option = '<option';
					$option .= " value=\"{$countryKey}\"";
					if ( $countryKey == $selectedBillingCountry ) {
						$option .= ' selected="selected"';
					}
					$option .= '>';
					$option .= MM_WPFS_Admin::translateLabelAdmin($countryObject['name']);
					$option .= '</option>';
					echo $option;
				}
				?>
			</select>
			<p class="description"><?php esc_html_e( "It's the selected country when the form is rendered for the first time, and is used also as the supplier's country for custom VAT calculation.", 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Collect Shipping Address?', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<label class="radio inline">
				<input type="radio" name="form_show_shipping_address_input" id="hide_address_input" value="0" <?php echo ( $form->showShippingAddress == '0' ) ? 'checked' : '' ?> >
				<?php esc_html_e( 'No', 'wp-full-stripe-admin' ); ?>
			</label>
			<label class="radio inline">
				<input type="radio" name="form_show_shipping_address_input" id="show_address_input" value="1" <?php echo ( $form->showShippingAddress == '1' ) ? 'checked' : '' ?> >
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
                    if ( $form->preferredLanguage == $language['value'] ) {
                        $option .= ' selected="selected"';
                    }
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
