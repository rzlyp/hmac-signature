<?php
namespace Devixel\HMAC;

class HMAC
{
    public function matching($tolerance, $signature, $private_key, $args = []){
        $time = Carbon::now()->subSeconds($remain_tolerance)->timestamp;
        $payload = $request_method.":".$path.":".$private_key.":".$request_payload.":".$time;
        $sign = hash_hmac('sha256', $payload, $secret);
    
        if($sign != $signature){
            if($remain_tolerance == 0){
                return false;
            }
            $tolerance -= 1;
            return $this->checkHMAC($tolerance, $signature, $private_key, $payload, $path, $request_method,  $request_payload);
        }
        return true;
    }
}