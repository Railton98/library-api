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

Route::group(['prefix' => 'auth', 'namespace' => 'Auth\\'], function() {
    Route::post('login', 'JWTController@login')->name('auth.login');

    Route::post('register', 'JWTController@register')->name('auth.register');

    Route::post('refresh', 'JWTController@refresh')->name('auth.refresh');

    Route::get('logout', 'JWTController@logout')->name('auth.logout');

    Route::group(['middleware' => 'jwt.auth'], function() {
        Route::get('me', 'JWTController@me')->name('auth.me');
    });

});

Route::middleware(['jwt.auth'])->group(function() {
    Route::apiResource('publications', 'PublicationController');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
