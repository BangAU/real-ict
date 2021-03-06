<?php

namespace StripeWPFS;

/**
 * Class Invoice
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property string|null $account_country The country of the business associated with this invoice, most often the business creating the invoice.
 * @property string|null $account_name The public name of the business associated with this invoice, most often the business creating the invoice.
 * @property int $amount_due Final amount due at this time for this invoice. If the invoice's total is smaller than the minimum charge amount, for example, or if there is account credit that can be applied to the invoice, the <code>amount_due</code> may be 0. If there is a positive <code>starting_balance</code> for the invoice (the customer owes money), the <code>amount_due</code> will also take that into account. The charge that gets generated for the invoice will be for the amount specified in <code>amount_due</code>.
 * @property int $amount_paid The amount, in %s, that was paid.
 * @property int $amount_remaining The amount remaining, in %s, that is due.
 * @property int|null $application_fee_amount The fee in %s that will be applied to the invoice and transferred to the application owner's Stripe account when the invoice is paid.
 * @property int $attempt_count Number of payment attempts made for this invoice, from the perspective of the payment retry schedule. Any payment attempt counts as the first attempt, and subsequently only automatic retries increment the attempt count. In other words, manual payment attempts after the first attempt do not affect the retry schedule.
 * @property bool $attempted Whether an attempt has been made to pay the invoice. An invoice is not attempted until 1 hour after the <code>invoice.created</code> webhook, for example, so you might not want to display that invoice as unpaid to your users.
 * @property bool $auto_advance Controls whether Stripe will perform <a href="https://stripe.com/docs/billing/invoices/workflow/#auto_advance">automatic collection</a> of the invoice. When <code>false</code>, the invoice's state will not automatically advance without an explicit action.
 * @property string|null $billing_reason Indicates the reason why the invoice was created. <code>subscription_cycle</code> indicates an invoice created by a subscription advancing into a new period. <code>subscription_create</code> indicates an invoice created due to creating a subscription. <code>subscription_update</code> indicates an invoice created due to updating a subscription. <code>subscription</code> is set for all old invoices to indicate either a change to a subscription or a period advancement. <code>manual</code> is set for all invoices unrelated to a subscription (for example: created via the invoice editor). The <code>upcoming</code> value is reserved for simulated invoices per the upcoming invoice endpoint. <code>subscription_threshold</code> indicates an invoice created due to a billing threshold being reached.
 * @property string|\StripeWPFS\Charge|null $charge ID of the latest charge generated for this invoice, if any.
 * @property string|null $collection_method Either <code>charge_automatically</code>, or <code>send_invoice</code>. When charging automatically, Stripe will attempt to pay this invoice using the default source attached to the customer. When sending an invoice, Stripe will email this invoice to the customer with payment instructions.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property string $currency Three-letter <a href="https://www.iso.org/iso-4217-currency-codes.html">ISO currency code</a>, in lowercase. Must be a <a href="https://stripe.com/docs/currencies">supported currency</a>.
 * @property \StripeWPFS\StripeObject[]|null $custom_fields Custom fields displayed on the invoice.
 * @property string|\StripeWPFS\Customer $customer The ID of the customer who will be billed.
 * @property \StripeWPFS\StripeObject|null $customer_address The customer's address. Until the invoice is finalized, this field will equal <code>customer.address</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property string|null $customer_email The customer's email. Until the invoice is finalized, this field will equal <code>customer.email</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property string|null $customer_name The customer's name. Until the invoice is finalized, this field will equal <code>customer.name</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property string|null $customer_phone The customer's phone number. Until the invoice is finalized, this field will equal <code>customer.phone</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property \StripeWPFS\StripeObject|null $customer_shipping The customer's shipping information. Until the invoice is finalized, this field will equal <code>customer.shipping</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property string|null $customer_tax_exempt The customer's tax exempt status. Until the invoice is finalized, this field will equal <code>customer.tax_exempt</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property \StripeWPFS\StripeObject[]|null $customer_tax_ids The customer's tax IDs. Until the invoice is finalized, this field will contain the same tax IDs as <code>customer.tax_ids</code>. Once the invoice is finalized, this field will no longer be updated.
 * @property string|\StripeWPFS\PaymentMethod|null $default_payment_method ID of the default payment method for the invoice. It must belong to the customer associated with the invoice. If not set, defaults to the subscription's default payment method, if any, or to the default payment method in the customer's invoice settings.
 * @property string|\StripeWPFS\StripeObject|null $default_source ID of the default payment source for the invoice. It must belong to the customer associated with the invoice and be in a chargeable state. If not set, defaults to the subscription's default source, if any, or to the customer's default source.
 * @property \StripeWPFS\TaxRate[]|null $default_tax_rates The tax rates applied to this invoice, if any.
 * @property string|null $description An arbitrary string attached to the object. Often useful for displaying to users. Referenced as 'memo' in the Dashboard.
 * @property \StripeWPFS\Discount|null $discount Describes the current discount applied to this invoice, if there is one.
 * @property int|null $due_date The date on which payment for this invoice is due. This value will be <code>null</code> for invoices where <code>collection_method=charge_automatically</code>.
 * @property int|null $ending_balance Ending customer balance after the invoice is finalized. Invoices are finalized approximately an hour after successful webhook delivery or when payment collection is attempted for the invoice. If the invoice has not been finalized yet, this will be null.
 * @property string|null $footer Footer displayed on the invoice.
 * @property string|null $hosted_invoice_url The URL for the hosted invoice page, which allows customers to view and pay an invoice. If the invoice has not been finalized yet, this will be null.
 * @property string|null $invoice_pdf The link to download the PDF for the invoice. If the invoice has not been finalized yet, this will be null.
 * @property \StripeWPFS\Collection $lines The individual line items that make up the invoice. <code>lines</code> is sorted as follows: invoice items in reverse chronological order, followed by the subscription, if any.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property \StripeWPFS\StripeObject|null $metadata Set of key-value pairs that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property int|null $next_payment_attempt The time at which payment will next be attempted. This value will be <code>null</code> for invoices where <code>collection_method=send_invoice</code>.
 * @property string|null $number A unique, identifying string that appears on emails sent to the customer for this invoice. This starts with the customer's unique invoice_prefix if it is specified.
 * @property bool $paid Whether payment was successfully collected for this invoice. An invoice can be paid (most commonly) with a charge or with credit from the customer's account balance.
 * @property string|\StripeWPFS\PaymentIntent|null $payment_intent The PaymentIntent associated with this invoice. The PaymentIntent is generated when the invoice is finalized, and can then be used to pay the invoice. Note that voiding an invoice will cancel the PaymentIntent.
 * @property int $period_end End of the usage period during which invoice items were added to this invoice.
 * @property int $period_start Start of the usage period during which invoice items were added to this invoice.
 * @property int $post_payment_credit_notes_amount Total amount of all post-payment credit notes issued for this invoice.
 * @property int $pre_payment_credit_notes_amount Total amount of all pre-payment credit notes issued for this invoice.
 * @property string|null $receipt_number This is the transaction number that appears on email receipts sent for this invoice.
 * @property int $starting_balance Starting customer balance before the invoice is finalized. If the invoice has not been finalized yet, this will be the current customer balance.
 * @property string|null $statement_descriptor Extra information about an invoice for the customer's credit card statement.
 * @property string|null $status The status of the invoice, one of <code>draft</code>, <code>open</code>, <code>paid</code>, <code>uncollectible</code>, or <code>void</code>. <a href="https://stripe.com/docs/billing/invoices/workflow#workflow-overview">Learn more</a>
 * @property \StripeWPFS\StripeObject $status_transitions
 * @property string|\StripeWPFS\Subscription|null $subscription The subscription that this invoice was prepared for, if any.
 * @property int $subscription_proration_date Only set for upcoming invoices that preview prorations. The time used to calculate prorations.
 * @property int $subtotal Total of all subscriptions, invoice items, and prorations on the invoice before any discount or tax is applied.
 * @property int|null $tax The amount of tax on this invoice. This is the sum of all the tax amounts on this invoice.
 * @property float|null $tax_percent This percentage of the subtotal has been added to the total amount of the invoice, including invoice line items and discounts. This field is inherited from the subscription's <code>tax_percent</code> field, but can be changed before the invoice is paid. This field defaults to null.
 * @property \StripeWPFS\StripeObject $threshold_reason
 * @property int $total Total after discounts and taxes.
 * @property \StripeWPFS\StripeObject[]|null $total_tax_amounts The aggregate amounts calculated per tax rate for all line items.
 * @property int|null $webhooks_delivered_at The time at which webhooks for this invoice were successfully delivered (if the invoice had no webhooks to deliver, this will match <code>created</code>). Invoice payment is delayed until webhooks are delivered, or until all webhook delivery attempts have been exhausted.
 *
 * @package StripeWPFS
 */
class Invoice extends ApiResource
{
    const OBJECT_NAME = 'invoice';

    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    use ApiOperations\NestedResource;

    /**
     * Possible string representations of the billing reason.
     *
     * @see https://stripe.com/docs/api/invoices/object#invoice_object-billing_reason
     */
    const BILLING_REASON_MANUAL                 = 'manual';
    const BILLING_REASON_SUBSCRIPTION           = 'subscription';
    const BILLING_REASON_SUBSCRIPTION_CREATE    = 'subscription_create';
    const BILLING_REASON_SUBSCRIPTION_CYCLE     = 'subscription_cycle';
    const BILLING_REASON_SUBSCRIPTION_THRESHOLD = 'subscription_threshold';
    const BILLING_REASON_SUBSCRIPTION_UPDATE    = 'subscription_update';
    const BILLING_REASON_UPCOMING               = 'upcoming';

    /**
     * Possible string representations of the `collection_method` property.
     *
     * @see https://stripe.com/docs/api/invoices/object#invoice_object-collection_method
     */
    const COLLECTION_METHOD_CHARGE_AUTOMATICALLY = 'charge_automatically';
    const COLLECTION_METHOD_SEND_INVOICE         = 'send_invoice';

    /**
     * Possible string representations of the invoice status.
     *
     * @see https://stripe.com/docs/api/invoices/object#invoice_object-status
     */
    const STATUS_DRAFT         = 'draft';
    const STATUS_OPEN          = 'open';
    const STATUS_PAID          = 'paid';
    const STATUS_UNCOLLECTIBLE = 'uncollectible';
    const STATUS_VOID          = 'void';

    /**
     * Possible string representations of the `billing` property.
     *
     * @deprecated Use `collection_method` instead.
     * @see https://stripe.com/docs/api/invoices/object#invoice_object-billing
     */
    const BILLING_CHARGE_AUTOMATICALLY = 'charge_automatically';
    const BILLING_SEND_INVOICE         = 'send_invoice';

    const PATH_LINES = '/lines';

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @throws \StripeWPFS\Exception\ApiErrorException if the request fails
     *
     * @return \StripeWPFS\Invoice The upcoming invoice.
     */
    public static function upcoming($params = null, $opts = null)
    {
        $url = static::classUrl() . '/upcoming';
        list($response, $opts) = static::_staticRequest('get', $url, $params, $opts);
        $obj = Util\Util::convertToStripeObject($response->json, $opts);
        $obj->setLastResponse($response);
        return $obj;
    }

    /**
     * @param string $id The ID of the invoice on which to retrieve the lines.
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @throws StripeExceptionApiErrorException if the request fails
     *
     * @return \StripeWPFS\Collection The list of lines (InvoiceLineItem).
     */
    public static function allLines($id, $params = null, $opts = null)
    {
        return self::_allNestedResources($id, static::PATH_LINES, $params, $opts);
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @throws \StripeWPFS\Exception\ApiErrorException if the request fails
     *
     * @return Invoice The finalized invoice.
     */
    public function finalizeInvoice($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/finalize';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @throws \StripeWPFS\Exception\ApiErrorException if the request fails
     *
     * @return Invoice The uncollectible invoice.
     */
    public function markUncollectible($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/mark_uncollectible';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @throws \StripeWPFS\Exception\ApiErrorException if the request fails
     *
     * @return Invoice The paid invoice.
     */
    public function pay($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/pay';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @throws \StripeWPFS\Exception\ApiErrorException if the request fails
     *
     * @return Invoice The sent invoice.
     */
    public function sendInvoice($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/send';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @throws \StripeWPFS\Exception\ApiErrorException if the request fails
     *
     * @return Invoice The voided invoice.
     */
    public function voidInvoice($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/void';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
}
