<?php

namespace App\Http\Middleware;

use Closure;

class Cors{
    public function handle($request, Closure $next, $guard = null){
    	if(strtolower($request->getMethod()) == 'options'){
    		return \Response('ok', 200)
    		->header('Access-Control-Allow-Origin', '*')
    		->header('Access-Control-Allow-Headers', 'Authorization, Origin, Content-Type, Accept, X-Requested-With')
    		->header('Access-Control-Allow-Method', 'POST');
    	}

    	return $next($request);
    }
}