<?php

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});


Route::apiResource('/employee', 'App\Http\Controllers\Api\EmployeeController');
Route::apiResource('/supplier', 'App\Http\Controllers\Api\SupplierController');
Route::apiResource('/category', 'App\Http\Controllers\Api\CategoryController');
Route::apiResource('/product', 'App\Http\Controllers\Api\ProductController');
Route::apiResource('/expense', 'App\Http\Controllers\Api\ExpenseController');

Route::Post('/salary/paid/{id}', 'App\Http\Controllers\Api\SalaryController@Paid');