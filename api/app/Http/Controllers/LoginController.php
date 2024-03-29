<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LoginController extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login(){
    	return \Response(
            array(
                'status'=>'success',
                'message'=> "authenticated",
                'data'=>null),
            200);
    }
}