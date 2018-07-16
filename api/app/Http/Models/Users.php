<?php

namespace App\Http\Models;

class Users extends \Eloquent{
	protected $table 	= 'users';
	protected $fillable = [
        'name',
        'email',
        'password'
    ];
    
    public $timestamps = false;
}