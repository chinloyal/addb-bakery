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

# Auth routes
Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard', function(){
		return view('dashboard.index');
	})->name('dashboard');

	Route::get('/manage/ingredients', function () {
		return view('dashboard.employee.ingredients');
	})->name('employee.ingredients')->middleware('role:admin|employee');

	Route::get('/manage/products', function () {
		return view('dashboard.employee.products');
	})->name('employee.products')->middleware('role:admin|employee');

	# Employee | Admin API Routes
	Route::group(['middleware' => 'role:admin|employee', 'prefix' => 'api'], function () {
		# Ingredients routes
		Route::get('ingredients', [
			'uses' => 'IngredientController@retrieveAll',
			'as' => 'ingredients'
		]);

		Route::post('ingredients/store', [
			'uses' => 'IngredientController@store',
			'as' => 'ingredients.store'
		]);

		Route::post('ingredients/update/{id}', [
			'uses' => 'IngredientController@update',
			'as' => 'ingredients.update'
		]);

		Route::delete('ingredients/delete/{id}', [
			'uses' => 'IngredientController@destroy',
			'as' => 'ingredients.delete'
		]);

		# Products routes
		Route::get('products', [
			'uses' => 'ProductController@retrieveAll',
			'as' => 'products'
		]);

		Route::post('products/store', [
			'uses' => 'ProductController@store',
			'as' => 'products.store'
		]);

		Route::post('products/update/{id}', [
			'uses' => 'ProductController@update',
			'as' => 'products.update'
		]);

		Route::delete('products/delete/{id}', [
			'uses' => 'ProductController@destroy',
			'as' => 'products.delete'
		]);
	});

	# Admin only API route
	Route::group([
		'middleware' => 'role:admin',
		'prefix' => 'api',
	], function () {
		Route::put('/permission/toggle/{permission_id}', [
			'uses' => 'Auth\\AuthController@togglePermission',
			'as' => 'permission.toggle'
		]);

		Route::get('employees', [
			'uses' => 'UserController@allEmployees',
			'as' => 'employees.all'
		]);
	});

	#Admin only Web route
	Route::group(['middleware' => 'role:admin'], function(){
		Route::get('/manage/employees', function () {
			return view('dashboard.admin.employees');
		})->name('admin.employees');

		Route::get('/manage/employees/{user_id}/permissions', [
			'uses' => 'Auth\\AuthController@employeePermissionView',
			'as' => 'admin.employee.permissions'
		]);

	});

});
