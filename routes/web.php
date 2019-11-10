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
	})->name('employee.ingredients')
		->middleware(['role:admin|employee', 'cando:Manage Ingredients']);

	Route::get('/manage/products', function () {
		return view('dashboard.employee.products');
	})->name('employee.products')
		->middleware(['role:admin|employee', 'cando:Manage Products']);

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

		Route::put('products/update/ingredients/{id}', [
			'uses' => 'ProductController@assignIngredients',
			'as' => 'products.ingredients.update'
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

		Route::get('/employees', [
			'uses' => 'UserController@allEmployees',
			'as' => 'employees.all'
		]);

		Route::post('/employee/create', [
			'uses' => 'UserController@storeEmployee',
			'as' => 'register.post'
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

	# Customer only
	Route::group(['middleware' => 'role:customer'], function () {
		Route::get('/customer/orders', function() {
			return view('dashboard.customer.orders');
		})->name('customer.orders');

		Route::get('products', function () {
			return view('dashboard.customer.products');
		})->name('customer.products');

		#Customer API's
		Route::group(['prefix' => 'api'], function () {
			Route::post('/order/place', [
				'uses' => 'OrderController@placeOrder',
				'as' => 'api.order.place'
			]);

			Route::get('/customer/orders', [
				'uses' => 'OrderController@getCustomerOrders',
				'as' => 'api.customer.orders'
			]);
		});
	});

	# Employee only
	Route::group(['middleware' => 'role:employee'], function () {

		#Employee Web
		Route::get('manage/orders', function() {
			return view('dashboard.employee.orders');
		})->name('employee.orders')
		->middleware('cando:Manage Orders');

		#Employee API's
		Route::group(['prefix' => 'api'], function () {
			Route::get('/employee/orders', [
				'uses' => 'OrderController@getEmployeeOrders',
				'as' => 'api.employee.orders'
			]);

			Route::put('toggle/order/{order_id}', [
				'uses' => 'OrderController@toggleStatus',
				'as' => 'toggle.order.status'
			]);
		});
	});

	# API's available to all auth users
	Route::group(['prefix' => 'api'], function() {
		Route::get('products', [
			'uses' => 'ProductController@retrieveAll',
			'as' => 'products'
		]);
	});
});
