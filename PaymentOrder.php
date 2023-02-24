<?php

namespace CpaySDK;

require_once "CpayBase.php";

class PaymentOrder extends CpayBase {
    /**
     * PaymentOrder constructor.
     * @param $config : for example ["merchantId"=>112233,"timeout"=>3,"host"=>"https://test.com","securityKey"=>"xxx"]
     * @throws \Exception
     */
    public function __construct($config) {
        require_once "CpayBase.php";
        parent::__construct($config);
    }

    /**
     * @param $merchantOrderId : (string) order id in merchant's system
     * @param $currency :    (string) currency of order
     * @param $uid :         (int) user id in merchant's system
     * @param $amount :      (string) total amount of order
     * @param $country :     (string) country code
     * @param $email :       (string) user's email
     * @param $products :    (json string) [{"name":"P1","price":"59.95","num":"1","currency":"USD"}]
     * @param $ip :          (string)
     * @param $callBackURL : (string) notify payment result to merchant by this api
     * @param $successURL :  (string) redirect url if payment is successful
     * @param $failURL :     (string) redirect url if payment is failed
     * @param $extInfo :     (json string)
     * @return array|mixed
     */
    public function createCreditCardPaymentOrder(
        $merchantOrderId,
        $currency,
        $uid,
        $amount,
        $country,
        $email,
        $ip,
        $products,
        $extInfo,
        $callBackURL,
        $successURL,
        $failURL
    ) {

        $params = [
            'merchantTradeNo' => "{$merchantOrderId}",
            'merchantId'      => 1 * $this->cfg['merchantId'],
            'createTime'      => time()*1000,
            'currency'        => $currency,
            'userId'          => 1 * $uid,
            'amount'          => "{$amount}",
            'country'         => $country,
            'email'           => $email,
            'products'        => $products,
            'ip'              => $ip,
            'callBackURL'     => $callBackURL,
            'successURL'      => $successURL,
            'failURL'         => $failURL,
            'extInfo'         => $extInfo,
        ];
        $params['sign'] = $this->genSign($params, $this->cfg['securityKey']);

        $c = new HttpClient($this->cfg['host'], $this->cfg['timeout']);
        return $c->doPostToCpay("/openapi/v1/createOrderByCreditCard", $params);
    }

    /**
     * @param $merchantOrderId
     * @param $currency
     * @param $uid
     * @param $amount
     * @param $callBackURL
     * @param $extInfo
     * @param string $successURL
     * @param string $failURL
     * @return array|mixed
     */
    public function createCryptoPaymentOrder(
        $merchantOrderId,
        $currency,
        $uid,
        $amount,
        $callBackURL,
        $extInfo,
        $successURL = '',
        $failURL = ''
    ) {
        $params = [
            'merchantTradeNo' => "{$merchantOrderId}",
            'merchantId'      => 1 * $this->cfg['merchantId'],
            'createTime'      => time()*1000,
            'cryptoCurrency'  => $currency,
            'userId'          => 1 * $uid,
            'amount'          => "{$amount}",
            'callBackURL'     => $callBackURL,
            'successURL'      => $successURL,
            'failURL'         => $failURL,
            'extInfo'         => $extInfo,
        ];
        $params['sign'] = $this->genSign($params, $this->cfg['securityKey']);

        $c = new HttpClient($this->cfg['host'], $this->cfg['timeout']);
        return $c->doPostToCpay("/openapi/v1/createOrder", $params);
    }

    /**
     * @param string $merchantOrderId
     * @param string $cpayOrderId
     * @param string $txHash
     * @return array|mixed
     * @throws \Exception
     */
    public function getPaymentOrder(
        $merchantOrderId = '',
        $cpayOrderId = '',
        $txHash = ''
    ) {
        if (empty($merchantOrderId) && empty($cpayOrderId) && empty($txHash)) {
            throw new \Exception('all params are empty');
        }
        $params = [
            'merchantId'      => 1 * $this->cfg['merchantId'],
            'merchantTradeNo' => "{$merchantOrderId}",
            'cpayOrderId'     => "{$cpayOrderId}",
            'hash'            => "{$txHash}",
        ];
        $params['sign'] = $this->genSign($params, $this->cfg['securityKey']);

        $c = new HttpClient($this->cfg['host'], $this->cfg['timeout']);
        return $c->doGetToCpay("/openapi/v1/getOrderDetail", $params);
    }
}

