<?php
namespace Devixel\HMAC;
require 'vendor/autoload.php';

use Carbon\Carbon;

class HMAC
{
    /**
     * @tolerance - Max tolerance for hmac signature
     * @signature - Signature that sended from the other side
     * @private_key - Access token that you used to generate the HMAC Encryption
     * @separator - Separator that you used to create the HMAC payload
     * @args - Argument or payload that you want to used such as ["email" => "test@mail.com", "time" => "90239303234"]
     * 
     */
    public static function matching($tolerance, $signature, $private_key, $separator = ":",  $args = []){
        $time = Carbon::now()->subSeconds($tolerance)->timestamp;
        $payload = "";
        foreach($args as $key => $value){
            $payload .= $separator.$value;
        }
        $payload .= $separator.$time;

        $sign = hash_hmac('sha256', $payload, $private_key);
    
        /**
         * Checking the similarities of the signature based on the max time of the tolerance using resursive function
         */

        if($sign != $signature){
            if($tolerance == 0){
                return false;
            }
            $tolerance -= 1;
            return $this->matching($tolerance, $signature, $private_key, $payload, $path, $request_method,  $request_payload);
        }
        return true;
    }
}