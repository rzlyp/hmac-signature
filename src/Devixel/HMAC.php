<?php
namespace Devixel;

use Carbon\Carbon;

class HMAC
{
    private $tolerance = 10;
    /**
     * @tolerance - Max tolerance for hmac signature
     * @signature - Signature that sended from the other side
     * @private_key - Access token that you used to generate the HMAC Encryption
     * @separator - Separator that you used to create the HMAC payload
     * @args - Argument or payload that you want to used such as ["email" => "test@mail.com", "time" => "90239303234"]
     * 
     */
    public static function matchingHmac($tolerance, $signature, $private_key, $separator = ":",  $args = []){
        return self::matching($tolerance, $signature, $private_key, $separator,  $args);
    }
    public static function matching($tolerance, $signature, $private_key, $separator = ":",  $args = []){
        $time = Carbon::now()->timezone('Etc/UTC')->subSeconds($tolerance)->timestamp;
        $payload = "";
        $i = 0;
        foreach($args as $key => $value){
            $payload .= $i == 0?$value:$separator.$value;

            $i++;
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
            return self::matching($tolerance, $signature, $private_key, $separator,  $args);
        }
        return true;

    }
    public static function validSignatureTime($timestamp, $tolerance = 0){
        $currentTime = Carbon::now()->timezone('Etc/UTC')->timestamp;
        $substractTime = $currentTime - $timestamp;

        if($substractTime <= $tolerance && $substractTime >= 0){
            return true;
        }else{
            return false;
        }
    }
}
