<?php

namespace CpaySDK;

require_once "CpayBase.php";

class Account extends CpayBase {

    /**
     * PaymentOrder constructor.
     * @param $config : for example ["merchantId"=>112233,"timeout"=>3,"host"=>"https://test.com","securityKey"=>"xxx"]
     * @throws \Exception
     */
    public function __construct($config) {
        parent::__construct($config);
    }

    /**
     * @param string $uid
     * @return array|mixed
     * @throws \Exception
     */
    public function getWalletAddress($uid) {
        if (empty($uid)) {
            throw new \Exception('all params are empty');
        }
        $params = [
            'merchantId'      => 1 * $this->cfg['merchantId'],
            'userId'          => "{$uid}",
        ];
        $params['sign'] = $this->genSign($params, $this->cfg['securityKey']);

        $c = new HttpClient($this->cfg['host'], $this->cfg['timeout']);
        return $c->doGetToCpay("/openapi/v1/getWalletAddress", $params);
    }
}

