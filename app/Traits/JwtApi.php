<?php

namespace App\Traits;

use \Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Exception;

trait JwtApi {      
    public function getToken(array $payload) {
        if(!array_key_exists('iss', $payload)) {
            $payload['iss'] = config('app.url');
        }
        if(!array_key_exists('iss', $payload)) {
            $payload['exp'] = Carbon::now()->addHours(config('jwt.token_live', 60))->timestamp;
        }
        return JWT::encode($payload, config('app.key'));      
    }

    public function getPayLoad(Request $request) {
        $headerAuth = explode(' ', $request->header('Authorization'));
        
        if(empty($headerAuth[1])) {           
            throw new Exception('Unauthorized.');            
        }        
        $token = $headerAuth[1];
        return (array)JWT::decode($token, config('app.key'), array('HS256'));        
    }
}