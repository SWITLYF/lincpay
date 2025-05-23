<?php

namespace Anand\LaravelPaytmWallet\Providers;

use Anand\LaravelPaytmWallet\Traits\HasTransactionStatus;

class StatusCheckProvider extends PaytmWalletProvider
{
    use HasTransactionStatus;

    private $parameters = null;

    protected $response;

    public function prepare($params = [])
    {
        $defaults = [
            'order' => null,
        ];

        $_p = array_merge($defaults, $params);
        foreach ($_p as $key => $value) {

            if ($value == null) {

                throw new \Exception(' \''.$key.'\' parameter not specified in array passed in prepare() method');

                return false;
            }
        }
        $this->parameters = $_p;

        return $this;
    }

    public function check()
    {
        if ($this->parameters == null) {
            throw new \Exception('prepare() method not called');
        }

        return $this->beginTransaction();
    }

    private function beginTransaction()
    {
        $params = [
            'MID' => $this->merchant_id,
            'ORDERID' => $this->parameters['order'],
        ];
        $chk = getChecksumFromArray($params, $this->merchant_key);
        $params['CHECKSUMHASH'] = $chk;
        $this->response = $this->api_call_new($this->paytm_txn_status_url, $params);

        return $this;
    }

    public function response()
    {
        return $this->response;
    }

    public function getOrderId()
    {
        return $this->response()['ORDERID'];
    }

    public function getTransactionId()
    {
        return $this->response()['TXNID'];
    }
}
