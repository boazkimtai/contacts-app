<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuth{
    public function handle($request, Closure $next, $guard = null){
        $headers = $request->headers->all();

        if(!isset($headers['php-auth-user']) || !isset($headers['php-auth-pw']) && 
            \Request::route()->getName() != 'login' && \Request::route()->getName() != 'users'){
            return \Response(
                array(
                    'status'=> 'error',
                    'message'=>'missing authentication data',
                    'data'=>null
                    ),
                400);
        } else {
            $db = \DB::table('users');

            $headers = \Request()->headers->all();
            $email   = $headers['php-auth-user'][0];
            $password= $headers['php-auth-pw'][0];

            $results = $db->get(array('email', 'password'))
                        ->where('email', $email)
                        ->take(1);

            if(count($results) == 0){
                return \Response(
                    array(
                        'status'=>'error',
                        'code'=>"BAD_AUTHENTICATION_DATA",
                        'message'=> 'wrong credentials'),
                    401);

            } else if(count($results) == 1) {
                $results = json_decode($results, true);
                $arr     = [];

                foreach ($results as $key => $value) {
                    $arr = $value;
                }

                if(\Hash::check($password, $arr['password'])){
                    return $next($request);
                } else {
                    return \Response(
                    array(
                        'status'=>'error',
                        'message'=> 'wrong credentials',
                        'code'=>"BAD_AUTHENTICATION_DATA",
                        'data'=> null),
                    401);
                }
            }
        }
    }
}