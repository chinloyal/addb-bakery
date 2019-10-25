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
    return view('splash.home');
})->name('home')->middleware('guest');

# Guest Routes
Route::group(['namespace' => 'Auth', 'as' => 'auth.'], function () {

	Route::get('/sign-up', [
		'uses' => 'RegisterController@index',
		'as' => 'register'
	]);

	Route::post('/sign-up', [
		'uses' => 'RegisterController@store',
		'as' => 'register.post'
	]);

	Route::get('/login', [
		'uses' => 'LoginController@showLoginForm',
		'as' => 'login'
	]);

	Route::post('/login', [
		'uses' => 'LoginController@login',
		'as' => 'login.post'
	]);

	Route::post('/logout', [
		'uses' => 'LoginController@logout',
		'as' => 'logout'
	]);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard', function(){
		return view('dashboard.index');
	})->name('dashboard');
});
