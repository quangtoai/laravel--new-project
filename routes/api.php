<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');

    });
    Route::group(['middleware' => 'auth:user'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('refresh', 'AuthController@refresh');
        });
        Route::get('profile', 'AuthController@getProfile');
        Route::put('Update', 'UserController@updateuser');
        Route::put('change', 'UserController@changePass');
        Route::apiResource('user', 'UserController');
        Route::apiResource('userproxy', 'UserProxyController');
        Route::apiResource('role', 'RoleController');
        Route::apiResource('setting', 'SettingController');
        
        Route::group(['prefix' => 'payslip'], function () {
            // Route::get('me','PayslipController@me');
            Route::get('detail','PayslipController@show');
            Route::post('import', 'PayslipController@store');
            Route::get('month', 'PayslipController@month');
        });
        Route::apiResource('payslip','PayslipController');
    });
    Route::get('userproxy','UserProxyController@index');
    Route::apiResource('roles', "RoleController")->middleware(['auth:user']);
    Route::get('permissions', 'RoleController@listPermission')->middleware(['auth:user']);
    Route::post('remind-passwords', 'AuthController@remindPassword');
    Route::put('change_pass/{emp_code}', 'AuthController@changePassword');

});

