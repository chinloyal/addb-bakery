<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Collection;

class OrderRepository implements OrderRepositoryInterface {
	public function store($data): bool {
		$order = new Order();
		$employee = Employee::all()->random(1)->first();
		$products = Product::whereIn('id', $data)->get();

		$order->employee_id = $employee->id;
		$order->customer_id = auth()->user()->id;
		$order->delivery_date = now()->addDay();
		$order->cost = $products->sum('unit_cost');

		$order->saveOrFail();

		$order->products()->attach($data);

		return true;
	}

	public function getCustomerOrders(): Collection {
		return auth()->user()->orders->map(function($order) {
			return [
				'delivery_date' => $order->delivery_date,
				'cost' => $order->cost,
				'gct' => $order->gct,
				'employee_name' => $order->employee->user->full_name,
				'completed' => $order->completed
			];
		});
	}
}
