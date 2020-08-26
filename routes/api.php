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
});


*/


Route::match(array('GET','POST'),'login', 'AppController@login');
Route::match(array('GET','POST'),'register', 'AppController@register');

Route::get('/v_check_customer_for_registration', 'AuthController@v_check_customer_for_registration');
Route::post('/v_update_customer_for_registration', 'AuthController@v_update_customer_for_registration');


Route::post('/reset_password', 'AuthController@reset_password');
Route::post('/update/reset_password', 'AuthController@reset_password');
Route::get('/get_prof_collection', 'AppController@get_prof_collection');

Route::post('/save_profile', 'AppController@save_profile');
Route::get('/etc_card', 'AppController@etc_card');

Route::get('/verify_mem_service', 'AppController@verify_mem_service');



Route::get('/etc_card2', 'AppController@etc_card2');
Route::get('/etc_card_test', 'AppController@etc_card_test');

Route::post('/update_profile', 'AppController@update_profile');
Route::post('/send_invite', 'AppController@send_invite');


Route::get('/about', 'AppController@about');
Route::get('/privacy', 'AppController@privacy');
Route::get('/terms', 'AppController@terms');
Route::get('/faqs', 'AppController@faqs');
Route::get('/security', 'AppController@security');

Route::post('/reset_password', 'AppController@reset_password');
Route::post('/resend_code', 'AppController@resend_code');

Route::post('/reply_to_ad', 'AppController@reply_to_ad');
Route::post('/filter_classifieds', 'AppController@filter_classifieds');

Route::get('/membership_status', 'AppController@membership_status');




