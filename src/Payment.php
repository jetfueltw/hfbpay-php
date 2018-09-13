<?php

namespace Jetfuel\Hfbpay;

use Jetfuel\Hfbpay\HttpClient\GuzzleHttpClient;
use Jetfuel\Hfbpay\Traits\ConvertMoney;

class Payment
{
    use ConvertMoney;

    const BASE_API_URL = 'http://122.114.86.192/gateway';

    /**
     * @var string
     */
    protected $merchantId;

    /**
     * @var string
     */
    protected $privateKey;

    /**
     * @var string
     */
    protected $publicKey;

    /**
     * @var string
     */
    protected $baseApiUrl;

    /**
     * @var \Jetfuel\Hfbpay\HttpClient\HttpClientInterface
     */
    protected $httpClient;

    /**
     * Payment constructor.
     *
     * @param string $orgId
     * @param string $merchantId
     * @param string $secretKey
     * @param null|string $baseApiUrl
     */
    protected function __construct($merchantId, $publicKey, $privateKey, $baseApiUrl = null)
    {
        $this->merchantId = $merchantId;
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->baseApiUrl = $baseApiUrl === null ? self::BASE_API_URL : $baseApiUrl;

        $this->httpClient = new GuzzleHttpClient($this->baseApiUrl);
    }

    /**
     * Sign request payload.
     *
     * @param array $payload
     * @return array
     */
    protected function signPayload(array $payload)
    {
        $payload['app_id'] = $this->merchantId;
        $payload['timestamp'] = $this->getCurrentTime();
        $payload['sign'] = Signature::generate($payload, $this->publicKey);

        return $payload;
    }

    /**
     * Get current time.
     *
     * @return string
     */
    protected function getCurrentTime()
    {
        return time();
    }

}
