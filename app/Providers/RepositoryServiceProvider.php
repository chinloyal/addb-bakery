<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\IngredientsRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\IngredientsRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductsRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\ProductsRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
		$this->app->bind(UserRepositoryInterface::class, UserRepository::class);
		$this->app->bind(IngredientsRepositoryInterface::class, IngredientsRepository::class);
		$this->app->bind(ProductsRepositoryInterface::class, ProductsRepository::class);
		$this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
		$this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }
}
