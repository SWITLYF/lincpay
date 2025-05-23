<?php

namespace Srmklive\PayPal\Traits\PayPalAPI;

trait PaymentRefunds
{
    /**
     * Show details for authorized payment.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/payments/v2/#authorizations_get
     */
    public function showRefundDetails(string $refund_id)
    {
        $this->apiEndPoint = "v2/payments/refunds/{$refund_id}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }
}
