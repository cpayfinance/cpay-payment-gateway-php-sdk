<?php
require_once "PaymentOrder.php";
require_once "Account.php";

$conf = [
    "merchantId" => 200,
    "timeout" => 3,
    "host" => "https://api.cpay.ltd",
    "securityKey" => "xxxxx"];

$c = new CpaySDK\PaymentOrder($conf);

echo "createCryptoPaymentOrder ==> ";
$resp = $c->createCryptoPaymentOrder(
    time(),
    "USDT",
    time(),
    "1",
    "http://xx.com/a/b",
    '{"a":"x"}',
    "http://xx.com/a/b/s",
    "http://xx.com/a/b/f"
);
var_dump($resp);
sleep(2);

echo "createCreditCardPaymentOrder ==> ";
$merchantOrderId = time();
$resp = $c->createCreditCardPaymentOrder(
    $merchantOrderId,
    "USD",
    time(),
    "1",
    "CN",
    "a@xx.com",
    "192.168.0.1",
    '[{"name":"P1","price":"59.95","num":"1","currency":"USD"}]',
    '{"a":"x"}',
    'http://xx.com/a/b',
    "http://xx.com/a/b/s",
    "http://xx.com/a/b/f"
);
var_dump($resp);

echo "getPaymentOrder ==> ";
$resp = $c->getPaymentOrder($merchantOrderId);
var_dump($resp);

echo "getPaymentOrder ==> ";
$resp = $c->getPaymentOrder("", "230223135312267989014");
var_dump($resp);

$a = new CpaySDK\Account($conf);
echo "getWalletAddress ==> ";
$resp = $a->getWalletAddress("1677230350");
var_dump($resp);
