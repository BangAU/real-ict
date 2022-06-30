<?php
/**
 * Created by PhpStorm.
 * User: tnagy
 * Date: 2017.03.02.
 * Time: 16:48
 */
?>
<table class="form-table">
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Form Type:', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<?php esc_html_e( 'Inline save card form', 'wp-full-stripe-admin' ); ?>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label class="control-label"><?php esc_html_e( 'Form Name:', 'wp-full-stripe-admin' ); ?> </label>
		</th>
		<td>
			<input type="text" class="regular-text" name="form_name" id="form_name" value="<?php echo $form->name; ?>" maxlength="<?php echo $form_data::NAME_LENGTH; ?>">

			<p class="description"><?php esc_html_e( 'This name will be used to identify this form in the shortcode i.e. [fullstripe_form name="formName" type="inline_save_card"].', 'wp-full-stripe-admin' ); ?></p>
		</td>
	</tr>
    <tr valign="top" id="stripe_description_row">
        <th scope="row">
            <label class="control-label">
                <?php esc_html_e( 'Description: ', 'wp-full-stripe-admin' ); ?>
            </label>
        </th>
        <td>
            <textarea rows="3" class="large-text code" name="stripe_description"><?php echo $form->stripeDescription; ?></textarea>
            <p class="description"><?php printf( __( 'It appears in the customer\'s "Details" section on the Stripe dashboard. You can use placeholders, see the <a target="_blank" href="%s">Help page</a> for more options.', 'wp-full-stripe-admin' ), admin_url( "admin.php?page=fullstripe-help#receipt-tokens" ) ); ?> </p>
        </td>
    </tr>
	<input type="hidden" name="form_custom" value="card_capture">
</table>
