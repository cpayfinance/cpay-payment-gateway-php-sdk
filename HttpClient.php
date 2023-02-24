<?php

namespace CpaySDK;

class HttpClient extends \Exception {

    private $host;
    private $timeout;

    public function __construct($host, $timeout = 5) {
        $this->host = $host;
        $this->timeout = $timeout;

        parent::__construct();
    }

    public function doPostToCpay($uri, $params = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->host.$uri);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 1000);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

        $resp = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch) > 0 || !empty(curl_error($ch)) || $httpCode != 200) {
            return [];
        }
        curl_close($ch);
        if (empty($resp)) {
            return [];
        }
        return json_decode($resp, true);
    }

    public function doGetToCpay($uri, $params = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->host.$uri.'?'.http_build_query($params));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 1000);
        curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout);

        $resp = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch) > 0 || !empty(curl_error($ch)) || $httpCode != 200) {
            return [];
        }
        curl_close($ch);
        if (empty($resp)) {
            return [];
        }
        return json_decode($resp, true);
    }
}
