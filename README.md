# hmac-signature
HMAC Signature validator for HTTP request based on the timestamp


# How to Use ?

```
composer require devixel/hmac-security
composer dump-autoload
```

How to use it?

```
use Carbon\Carbon;
use Devixel\HMAC;

$tolerance = 10;
$private_key = env("private_key_hmac");

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

$separator = ":";

$hmac_match = HMAC::matchingHmac($tolerance, $signature, $private_key, $separator,  $args);

if($hmac_match){
      //matching the signature success
}else{
  //some actions
}


```


