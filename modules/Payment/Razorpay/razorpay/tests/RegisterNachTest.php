<?php

namespace Razorpay\Tests;

class RegisterNachTest extends TestCase
{
    /**
     * Specify unique customer id, invoice id, order id & token id
     * for example : cust_BMB3EwbqnqZ2EI, inv_IF37M4q6SdOpjT,
     * order_IF1TQZozl6Leaw & token_IF1ThOcFC9J7pU
     */
    private $customerId = 'cust_BMB3EwbqnqZ2EI';

    private $invoiceId = 'inv_IF37M4q6SdOpjT';

    private $orderId = 'order_IF1TQZozl6Leaw';

    private $tokenId = 'token_IF1ThOcFC9J7pU';

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Create customer
     */
    public function testCreateCustomerForNachTest()
    {
        $data = $this->api->customer->create(['name' => 'Razorpay User 21', 'email' => 'customer21@razorpay.com', 'fail_existing' => '0']);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('customer', $data->toArray()));
    }

    /**
     * Create Order
     */
    public function testCreateOrderForNachTest()
    {
        $data = $this->api->order->create(['receipt' => '123', 'amount' => 100, 'currency' => 'INR', 'notes' => ['key1' => 'value3', 'key2' => 'value2']]);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('id', $data->toArray()));
    }

    /**
     * Send/Resend notifications
     */
    public function testSendNotification()
    {
        $data = $this->api->invoice->fetch($this->invoiceId)->notifyBy('email');

        $this->assertTrue(in_array('success', $data));
    }

    /**
     * Create registration link
     */
    public function testCreateSubscriptionRegistration()
    {
        $data = $this->api->subscription->createSubscriptionRegistration(['customer' => ['name' => 'Gaurav Kumar', 'email' => 'gaurav.kumar@example.com', 'contact' => '9123456780'], 'amount' => 0, 'currency' => 'INR', 'type' => 'link', 'description' => '12 p.m. Meals', 'subscription_registration' => ['method' => 'nach', 'auth_type' => 'physical', 'bank_account' => ['beneficiary_name' => 'Gaurav Kumar', 'account_number' => '11214311215411', 'account_type' => 'savings', 'ifsc_code' => 'HDFC0001233'], 'nach' => ['form_reference1' => 'Recurring Payment for Gaurav Kumar', 'form_reference2' => 'Method Paper NACH'], 'expire_at' => 1636772800, 'max_amount' => 50000], 'receipt' => 'Receipt No. '.time(), 'sms_notify' => 1, 'email_notify' => 1, 'expire_by' => 1636772800, 'notes' => ['note_key 1' => 'Beam me up Scotty', 'note_key 2' => 'Tea. Earl Gray. Hot.']]);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('id', $data->toArray()));
    }

    /**
     * Fetch Payment ID using Order ID
     */
    public function testFetchPaymentByorderId()
    {
        $data = $this->api->order->fetch($this->orderId)->payments();

        $this->assertTrue(is_array($data->toArray()));
    }

    /**
     * Fetch tokens by customer id
     */
    public function testFetchTokenByCustomerId()
    {
        $data = $this->api->customer->fetch($this->customerId)->tokens()->all();

        $this->assertTrue(is_array($data->toArray()));
    }

    /**
     * Fetch token by payment ID
     */
    public function testFetchTokenByPaymentId()
    {
        $payment = $this->api->payment->all();

        if (! empty($payment)) {

            $data = $this->api->payment->fetch($payment['items'][0]['id']);

            $this->assertTrue(is_array($data->toArray()));

            $this->assertArrayHasKey('id', $data->toArray());
        }
    }

    /**
     * Create an order to charge the customer
     */
    public function testCreateOrderCharge()
    {
        $data = $this->api->order->create(['receipt' => '122', 'amount' => 100, 'currency' => 'INR', 'notes' => ['key1' => 'value3', 'key2' => 'value2']]);

        $this->assertTrue(is_array($data->toArray()));

        $this->assertTrue(in_array('id', $data->toArray()));
    }

    /**
     * Create a Recurring Payment
     */
    public function testCreateRecurring()
    {
        $order = $this->api->order->create(['amount' => 100, 'currency' => 'INR', 'method' => 'emandate', 'payment_capture' => '1', 'customer_id' => $this->customerId, 'token' => ['auth_type' => 'netbanking', 'max_amount' => 9999900, 'expire_at' => 2147483647, 'bank_account' => ['beneficiary_name' => 'Gaurav Kumar', 'account_number' => '1121431121541121', 'account_type' => 'savings', 'ifsc_code' => 'HDFC0000001'],
        ], 'receipt' => 'Receipt No. 1']);

        $data = $this->api->payment->createRecurring(['email' => 'gaurav.kumar@example.com', 'contact' => '9123456789', 'amount' => 100, 'currency' => 'INR', 'order_id' => $order->id, 'customer_id' => $this->customerId, 'token' => $this->tokenId, 'recurring' => '1', 'description' => 'Creating recurring payment for Gaurav Kumar']);

        $this->assertTrue(is_array($data->toArray()));

    }
}
