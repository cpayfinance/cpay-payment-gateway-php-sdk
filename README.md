# CPay Payment Gateway PHP SDK

`CPay Payment Gateway PHP SDK` is written in PHP.

# Quickstart

## Prerequisites
- PHP (CURL and JSON extension are required)
- MerchantID and SecurityKey (from cpay team)

## Install
`git clone https://github.com/cpayfinance/cpay-payment-gateway-go-sdk.git`

## Usage
The `Examples.php` is a good place to start.
The minimal you'll need to have is:

```
// 1. set the configuration
$config = [
  "securityKey" => "xxx", // generated by cpay
  "merchantId" => 112233, // generated by cpay
  "timeout" => 3,
  "host" => "https://test.com"
];


// 2. call the APIs
try {
  echo "call createCryptoPaymentOrder ==> ";
  $c = new CpaySDK\PaymentOrder($config);
  $resp = $c->createCryptoPaymentOrder(
    $config["merchantId"]."-xxxx",
    "USDT",
    1200000, // generated by your own system
    "1",
    "http://xx.com/a/b",
    '{"a":"x"}',
    "http://xx.com/a/b/s",
    "http://xx.com/a/b/f"
  );
  var_dump($resp);
} catch {
  echo "failed:".$ex->getMessage();
}

```

