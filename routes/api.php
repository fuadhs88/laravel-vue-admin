<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});


Route::namespace('App\\Http\\Controllers\\API\V1')->group(function () {
    Route::get('profile', 'ProfileController@profile');
    Route::put('profile', 'ProfileController@updateProfile');
    Route::post('change-password', 'ProfileController@changePassword');
    Route::get('tags/list', 'TagController@list');
    Route::get('categories/list', 'CategoryController@list');
    Route::post('products/upload', 'ProductController@upload');

    Route::apiResources([
        'users'      => 'UserController',
        'products'   => 'ProductController',
        'categories' => 'CategoryController',
        'tags'       => 'TagController',
    ]);
});
