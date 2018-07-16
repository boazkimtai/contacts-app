<?php

namespace App\Http\Controllers;
use \App\Http\Models\Users;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UsersController extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public $rules = array(
    		'name' => 'required|min:4|max:30|regex:/(^([a-z]){1,15})\s([a-z]){1,15}/i',
    		'email' => 'required|unique:users|email|max:30',
    		'password' => 'required|string|max:30'
    	);

    private $selectedFields = array(
    			'name',
    			'email',
    			'id');

    public function all(){
    	$db = \DB::table('users');


    	$results = $db->get($this->selectedFields)
    				->where('deleted', 0);
	
    	return \Response(
    			array(
    				'status'=>'success',
    				'message'=> null,
    				'data'=>$results),
    			200);
    }

    public function get($id){
    	$db = \DB::table('users');

    	$results = $db->find($id, $this->selectedFields);

    	if(count($results) > 0){
    		return \Response(
    		array(
    			'status'=>'success',
    			'message'=> null,
    			'data'=>$results),
    		200);
    	} else {
    		return \Response(
                array(
                    'status'=>'error',
                    'message'=> 'unknown error',
                    'data'=>null),
            200);
    	}
    }

    public function create(){
    	$data = \Request()->json()->all();

    	$validator = \Validator::make($data, $this->rules);

    	if($validator->fails()){
    		return \Response(
    			array(
    				'status'=>'error',
    				'message'=> '',
    				'errors'=> $validator->messages()),
    			400);
    	}

    	$db =\DB::table('users');
    	$data['password'] = \Hash::make($data['password']);

    	$q = $db->insert($data);

    	if($q){
    		return \Response(
    			array(
    				'status'=>'success',
    				'message'=> 'created',
    				'data'=>$data),
    			201);
    	} else {
    		return \Response(
    			array(
    				'status'=>'error',
    				'message'=> 'unknown error',
    				'errors'=> null),
    			200);
    	}
    }

    public function update($id){
    	$user = (new Users()) -> find($id);
    	$data = \Request()->json()->all();

    	unset($data['password']);

    	if(!$user){
    		return \Response(
    			array(
    				'status'=>'error',
    				'message'=> 'not found',
    				'errors'=>null),
    		404);
    	}

    	foreach ($data as $key => $value) {
    		if(!in_array($key, array_keys($this->rules))){
    			unset($data[$key]);
    		}
    	}
    	
    	 foreach ($this->rules as $key => $value) {
    		 if(!in_array($key, array_keys($data))){
    			 unset($this->rules[$key]);
    		 }
    	 }
    	
    	$validator = \Validator::make($data, $this->rules);

        $msgs = json_decode($validator->messages(), true);

    	if($validator->fails() && count($msgs) == 0){
            $results = $user->update($data);

            if(count($results) > 0){
               return \Response(
                    array(
                        'status'=>'success',
                        'message'=> 'updated',
                        'data'=>null),
                200);
            } else {
                return \Response(
                    array(
                        'status'=>'error',
                        'message'=> 'unknown error',
                        'data'=>null),
                200);
            }
    	} else {
            if($validator->fails()){
                return \Response(
                    array(
                        'status'=>'error',
                        'message'=> '',
                        'data'=> $msgs),
                    200);
            }

            $results = $user->update($data);

            if(count($results) > 0){
               return \Response(
                    array(
                        'status'=>'success',
                        'message'=> 'updated',
                        'data'=>null),
                200);
            } else {
                return \Response(
                    array(
                        'status'=>'error',
                        'message'=> 'unknown error',
                        'data'=>null),
                200);
            }
        }
    }

    public function delete($id){
        $user = (new Users()) -> find($id);

        if($results){
            return \Response(
                array(
                    'status'=>'success',
                    'message'=> 'deleted',
                    'data'=>null),
            200);
        } else {
            return \Response(
                array(
                    'status'=>'error',
                    'message'=> 'unknown error',
                    'data'=>null),
            200);
        }
    }

    public function updatePassword($id){
    	$data = \Request()->json()->all();

    	$validator = \Validator::make($data,
    		array(
    		'password' => 'required|max:100|string'
    	));

    	if($validator->fails()){
    		return \Response(
    			array(
    			'status'=>'error',
    			'message'=> '',
    			'data'=> $validator->messages()),
    		200);
    	}
    	
    	$db = \DB::table('users');
    	$user = $db->find($id);

    	$user = (array) $user;
 		$user['password'] = \Hash::make($data['password']);

		$results = $db->update($user);

		if ($results) {
			return \Response(
    			array(
    				'status'=>'success',
    				'message'=> 'updated',
    				'data'=>null),
    		200);
		} else {
			return \Response(
    		array(
    			'status'=>'error',
    			'message'=> 'unknown error',
    			'data'=>null),
    		200);
		}
    }
}
