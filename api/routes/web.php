<?php
	
	use \App\Http\Controllers\RequestsController;
	
	Route::group(['middleware' => 'auth'], function(){
		Route::group(array('prefix'=>'/auth'), function () {
			Route::post('/login', array('uses' => 'LoginController@login'));
		});

		Route::group(array('prefix'=>'/contacts'), function () {
			Route::get('/', array('uses' => 'ContactsController@all'));
		});
	});

	Route::group(array('prefix'=>'/users'), function () {
		Route::post('/', array('uses' => 'UsersController@create'));
	});