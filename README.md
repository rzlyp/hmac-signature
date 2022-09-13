# hmac-signature
HMAC Signature validator for HTTP request based on the timestamp


# How to Use ?

```
composer require devixel/hmac-security
composer dump-autoload
```

How to use it? 

Make Sure you're using the Etc/UTC Timezone for signature, so we don't need to think about the Timezone differences of the each client.


# Matching HMAC Signature

```php
use Carbon\Carbon;
use Devixel\HMAC;

$tolerance = 10;
$private_key = env("private_key_hmac");

$time = Carbon::now()->timezone('Etc/UTC')->timestamp;
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

/**
     * @tolerance - Max tolerance for hmac signature
     * @signature - Signature that sended from the other side
     * @private_key - Access token that you used to generate the HMAC Encryption
     * @separator - Separator that you used to create the HMAC payload
     * @args - Argument or payload that you want to used such as ["email" => "test@mail.com", "time" => "90239303234"]
     * 
*/

$hmac_match = HMAC::matchingHmac($tolerance, $signature, $private_key, $separator,  $args);

if($hmac_match){
      //matching the signature success
}else{
  //some actions
}


```


# Time Validate

```php
use Carbon\Carbon;
use Devixel\HMAC;

$time = time(); //client request timestamp
$tolerance = 10; //you can add the tolerance of each request due the latency problem, Default to 0 second

$validate_time = HMAC::validSignatureTime($time, $tolerance);
```

