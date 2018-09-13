<?php

namespace Jetfuel\Hfbpay;

use Jetfuel\Hfbpay\Traits\ResultParser;
use Jetfuel\Hfbpay\Constants\Channel;

class DigitalPayment extends Payment
{
    use ResultParser;

    /**
     * DigitalPayment constructor.
     *
     * @param string $merchantId
     * @param string $publicKey
     * @param string $privateKey
     * @param null|string $baseApiUrl
     */
    public function __construct($merchantId, $publicKey, $privateKey, $baseApiUrl = null)
    {
        parent::__construct($merchantId, $publicKey, $privateKey, $baseApiUrl);
    }

    /**
     * Create digital payment order.
     *
     * @param string $tradeNo
     * @param string $channel
     * @param float $amount
     * @param string $notifyUrl
     * @return array
     */
    public function order($tradeNo, $channel, $amount, $notifyUrl)
    {
        $payload = $this->signPayload([
            'method'        => 'trade.create',
            'product_code'  => $channel,
            'out_trade_no'  => $tradeNo,
            'notify_url'    => $notifyUrl,
            'amount'        => $amount,
        ]);

        return $this->parseResponse($this->httpClient->get('', $payload));
    }
}
