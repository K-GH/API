<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
 	   return $request->user();
});*/

Route::post('user/register','API\SignUpInController@register' );

Route::post('user/login','API\SignUpInController@login' );


//auth with jwt if success return user details
Route::middleware('jwt.auth')->get('/users', function (Request $request) {
    return auth()->user();
});


//auth with group and  
Route::middleware('jwt.auth')->group( function(){
    Route::resource('books', 'API\BookController') ;
} );