<?php
/**
 * Created by PhpStorm.
 * User: tnagy
 * Date: 2017.02.23.
 * Time: 14:57
 */
?>
<h2 id="create-checkout-donation-form-tabs" class="nav-tab-wrapper wpfs-admin-form-tabs">
    <a href="#create-checkout-donation-form-tab-payment" class="nav-tab"><?php esc_html_e( 'Payment', 'wp-full-stripe-admin' ); ?></a>
    <a href="#create-checkout-donation-form-tab-appearance" class="nav-tab"><?php esc_html_e( 'Appearance', 'wp-full-stripe-admin' ); ?></a>
    <a href="#create-checkout-donation-form-tab-custom-fields" class="nav-tab"><?php esc_html_e( 'Custom Fields', 'wp-full-stripe-admin' ); ?></a>
    <a href="#create-checkout-donation-form-tab-actions-after-payment" class="nav-tab"><?php esc_html_e( 'Actions after payment', 'wp-full-stripe-admin' ); ?></a>
</h2>
<form class="form-horizontal wpfs-admin-form" action="" method="POST" id="create-checkout-donation-form">
    <p class="tips"></p>
    <input type="hidden" name="action" value="wp_full_stripe_create_checkout_donation_form">
    <div id="create-checkout-donation-form-tab-payment" class="wpfs-tab-content">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Form Type:', 'wp-full-stripe-admin' ); ?> </label>
                </th>
                <td><?php esc_html_e( 'Checkout donation form', 'wp-full-stripe-admin' ); ?></td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Form Name:', 'wp-full-stripe-admin' ); ?> </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="form_name" id="form_name" maxlength="<?php echo $form_data::NAME_LENGTH; ?>">

                    <p class="description"><?php esc_html_e( 'This name will be used to identify this form in the shortcode i.e. [fullstripe_form name="formName" type="inline_donation"]', 'wp-full-stripe-admin' ); ?></p>
                </td>
            </tr>
            <tr valign="top" id="donation_currency_row">
                <th scope="row">
                    <label class="control-label" for="currency"><?php esc_html_e( "Donation Currency: ", 'wp-full-stripe-admin' ); ?></label>
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
            <tr valign="top" id="donation_amount_list_row">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Donation Amount Options:', 'wp-full-stripe-admin' ); ?> </label>
                </th>
                <td>
                    <input type="text" id="donation_amount_value" placeholder="<?php esc_attr_e( 'Amount', 'wp-full-stripe-admin' ); ?>" maxlength="<?php echo $form_data::PAYMENT_AMOUNT_LENGTH; ?>">
                    <a href="#" class="button button-primary" id="add_donation_amount_button"><?php esc_html_e( 'Add', 'wp-full-stripe-admin' ); ?></a>
                    <ul id="donation_amount_list"></ul>
                    <p class="description"><?php esc_html_e( 'The amount is in the smallest unit for the currency. i.e. for $10.00 enter 1000, for ¥10 enter 10. You can use drag\'n\'drop to reorder the donation amounts.', 'wp-full-stripe-admin' ); ?></p>
                    <br/>
                    <label class="checkbox inline"><input type="checkbox" name="allow_custom_donation_amount" id="allow_custom_donation_amount" value="1"><?php esc_html_e( 'Allow Custom Amount to Be Entered?', 'wp-full-stripe-admin' ); ?></label>
                    <input type="hidden" name="donation_amount_values">
                </td>
            </tr>
            <tr valign="top" id="donation_frequencies_row">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Recurring Donation Frequencies:', 'wp-full-stripe-admin' ); ?> </label>
                </th>
                <td>
                    <label class="checkbox inline"><input type="checkbox" name="allow_daily_recurring" id="allow_daily_recurring" value="1"><?php esc_html_e( 'Daily', 'wp-full-stripe-admin' ); ?></label>
                    <label class="checkbox inline"><input type="checkbox" name="allow_weekly_recurring" id="allow_weekly_recurring" value="1"><?php esc_html_e( 'Weekly', 'wp-full-stripe-admin' ); ?></label>
                    <label class="checkbox inline"><input type="checkbox" name="allow_monthly_recurring" id="allow_monthly_recurring" value="1"><?php esc_html_e( 'Monthly', 'wp-full-stripe-admin' ); ?></label>
                    <label class="checkbox inline"><input type="checkbox" name="allow_annual_recurring" id="allow_annual_recurring" value="1"><?php esc_html_e( 'Annual', 'wp-full-stripe-admin' ); ?></label>
                </td>
            </tr>
            <tr valign="top" id="stripe_description_row">
                <th scope="row">
                    <label class="control-label">
                        <?php esc_html_e( 'Donation description: ', 'wp-full-stripe-admin' ); ?>
                    </label>
                </th>
                <td>
                    <textarea rows="3" class="large-text code" name="stripe_description"><?php echo esc_html( MM_WPFS_Utils::create_default_donation_stripe_description() ); ?></textarea>
                    <p class="description"><?php printf( __( 'It appears in the "Payment details" section of the payment on the Stripe dashboard. You can use placeholders, see the <a target="_blank" href="%s">Help page</a> for more options.', 'wp-full-stripe-admin' ), admin_url( "admin.php?page=fullstripe-help#receipt-tokens" ) ); ?> </p>
                </td>
            </tr>
        </table>
    </div>
    <div id="create-checkout-donation-form-tab-appearance" class="wpfs-tab-content">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Product Name:', 'wp-full-stripe-admin' ); ?> </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="prod_desc" id="prod_desc" maxlength="<?php echo $form_data::PRODUCT_DESCRIPTION_LENGTH; ?>" value="<?php echo esc_attr( MM_WPFS_Admin_PopupDonationFormModel::getDefaultProductDescription() ); ?>">

                    <p class="description"><?php esc_html_e( 'The name of the product or service sold using this form.', 'wp-full-stripe-admin' ); ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Product Description:', 'wp-full-stripe-admin' ); ?> </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="company_name" id="company_name" maxlength="<?php echo $form_data::COMPANY_NAME_LENGTH; ?>">

                    <p class="description"><?php esc_html_e( 'A short description (one line) about the product or service sold using this form.', 'wp-full-stripe-admin' ); ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label class="control-label"><?php esc_html_e( 'Product Image:', 'wp-full-stripe-admin' ); ?></label>
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
                    <input type="text" class="regular-text" name="open_form_button_text" id="open_form_button_text" value="<?php esc_html_e( 'Donate', 'wp-full-stripe-admin' ); ?>" maxlength="<?php echo $form_data::OPEN_BUTTON_TITLE_LENGTH; ?>">

                    <p class="description"><?php esc_html_e( 'You can use the {{amount}} placeholder to display the selected/entered donation amount.', 'wp-full-stripe-admin' ); ?></p>
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
    <div id="create-checkout-donation-form-tab-custom-fields" class="wpfs-tab-content">
        <?php include('create_payment_form_tab_custom_fields.php'); ?>
    </div>
    <div id="create-checkout-donation-form-tab-actions-after-payment" class="wpfs-tab-content">
        <?php include('create_payment_form_tab_actions_after_payment.php'); ?>
    </div>
    <p class="submit">
        <button class="button button-primary" type="submit"><?php esc_html_e( 'Create Form', 'wp-full-stripe-admin' ); ?></button>
        <a href="<?php echo admin_url( 'admin.php?page=fullstripe-donations&tab=forms' ); ?>" class="button"><?php esc_html_e( 'Cancel', 'wp-full-stripe-admin' ); ?></a>
        <img src="<?php echo MM_WPFS_Assets::images( 'loader.gif' ); ?>" alt="<?php esc_attr_e( 'Loading...', 'wp-full-stripe-admin' ); ?>" class="showLoading"/>
    </p>
</form>
