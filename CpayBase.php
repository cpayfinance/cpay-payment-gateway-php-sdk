<?php

namespace CpaySDK;

class CpayBase {

    protected $cfg;

    /**
     * PaymentOrder constructor.
     * @param $config : for example ["merchantId"=>112233,"timeout"=>3,"host"=>"https://test.com","securityKey"=>"xxx"]
     * @throws \Exception
     */
    public function __construct($config) {
        if (!function_exists("doGetToCpay")) {
            require_once "HttpClient.php";
        }
        if (!function_exists('curl_init')) {
            throw new \Exception('sdk needs the CURL PHP extension.');
        }
        if (!function_exists('json_decode')) {
            throw new \Exception('sdk needs the JSON PHP extension.');
        }

        if (!isset($config['host']) || empty($config['host'])) {
            throw new \Exception('invalid host');
        }
        if (!isset($config['securityKey']) || empty($config['securityKey'])) {
            throw new \Exception('invalid securityKey');
        }
        if (!isset($config['securityKey']) || empty($config['securityKey'])) {
            throw new \Exception('invalid securityKey');
        }
        if (!isset($config['timeout']) || $config['timeout'] <= 0) {
            throw new \Exception('invalid timeout');
        }

        $this->cfg = $config;
    }

    protected function genSign($param, $securityKey) {
        if (!is_array($param) || count($param) == 0) {
            return '';
        }

        ksort($param);
        $ps = '';
        foreach ($param as $k => $v) {
            if (!empty($v)) {
                $ps = $ps . "{$k}={$v}&";
            }
        }
        $ps = $ps.'key='.$securityKey;
        return hash_hmac("sha256", $ps, $securityKey);
    }
}