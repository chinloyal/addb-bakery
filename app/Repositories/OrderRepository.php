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
				'delivery_date' => $order->time_of_placement->addDay()->format('d M, Y @ h:i A'),
				'cost' => $order->cost,
				'gct' => $order->gct,
				'employee_name' => $order->employee->user->full_name,
				'completed' => $order->completed,
				'products' => $order->products
			];
		});
	}

	public function getEmployeeOrders(): Collection {
		return auth()->user()->userable->orders->map(function($order) {
			$cost = $order->cost;
			return [
				'id' => $order->id,
				'delivery_date' => $order->time_of_placement->addDay()->format('d M, Y @ h:i A'),
				'time_of_placement' => $order->time_of_placement->format('d M, Y @ h:i A'),
				'customer_name' => $order->customer->full_name,
				'cost' => (($cost * ($order->gct / 100)) + $cost),
				'products' => $order->products,
				'status' => $order->completed
			];
		});
	}

	public function toggleStatus(int $order_id): bool {
		$order = Order::find($order_id);

		if(filled($order)) {
			$order->toggleComplete();
			return true;
		}

		return false;
	}
}
