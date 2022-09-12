<?php
require 'vendor/autoload.php';
require_once('src/Devixel/HMAC.php');

use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use Devixel\HMAC;

class HMACTest extends TestCase
{
    public function testHMAC()
    {
        $tolerance = 10;
        $private_key = "LfcTNyO1QhEfuaQrpKm0iCXXs5rEhcOA";

        $time = Carbon::now()->timestamp;
        $url = "login/test";
        $request_payload = [
            "id" => 1,
            "name" => "Jon Doe",
            "address" => "113 Manchester Rd, St. Louis, MO, USA",
            "transaction_id" => "INV/3323/2022-666"
        ];
        $request_payload = md5(json_encode($request_payload));
        $request_method = "POST";
        $payload = $request_method.":".$url.":". $request_payload.":".$private_key.":".$time;

        $signature =  hash_hmac('sha256', $payload, $private_key);

        $args = [
            "request_method" => $request_method,
            "url" => $url,
            "request_payload" => $request_payload,
            "private_key" => $private_key
        ];
       
        $hmac = HMAC::matchingHmac($tolerance, $signature, $private_key, $separator = ":",  $args);


        $this->assertTrue($hmac);

    }
}