<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('home');
});

Route::get('/hardware', function(){
    return view('hardware');
});

Route::get('/announcement', function(){
    return view('announcement');
});

Route::get('/resource', function(){
    return view('resource');
});
Route::get('/500hash', function(){
    return view('500hash');
});

Route::get('/admin', function(){
    return view('admin');
})->middleware('admin.auth');