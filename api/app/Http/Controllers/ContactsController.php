<?php

namespace App\Http\Controllers;
use \App\Http\Models\Contacts;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContactsController extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public $rules = array(
    		'name' => 'required|min:4|max:30|regex:/(^([a-z]){1,15})\s([a-z]){1,15}/i',
    		'phone' => 'required|number|unique:contacts',
            'age' => 'required:|number|min:1900|max:2004'
    	);

    private $selectedFields = array(
    			'name',
    			'phone',
                'age',
    			'id');

    public function all(){
    	$db = \DB::table('contacts');

    	$results = $db->get($this->selectedFields)
    				->where('deleted', 0);
	
    	return \Response(
    			array(
    				'status'=>'success',
    				'message'=> null,
    				'data'=>$results),
    			200);
    }

    public function create(){
    	$data = \Request()->json()->all();

    	$validator = \Validator::make($data, $this->rules);

    	if($validator->fails()){
    		return \Response(
    			array(
    				'status'=>'error',
    				'message'=> '',
    				'data'=> $validator->messages()),
    			200);
    	}

    	$db =\DB::table('contacts');
    	$data['password'] = \Hash::make($data['password']);

    	$q = $db->insert($data);

    	if($q){
    		return \Response(
    			array(
    				'status'=>'success',
    				'message'=> 'created',
    				'data'=>$data),
    			200);
    	} else {
    		return \Response(
    			array(
    				'status'=>'error',
    				'message'=> 'unknown error',
    				'data'=>null),
    			503);
    	}
    }
}