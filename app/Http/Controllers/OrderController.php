<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
	protected $orderRepo;

	public function __construct(OrderRepositoryInterface $orderRepo){
		$this->middleware('cando:Manage Orders')->only('getEmployeeOrders');
		$this->orderRepo = $orderRepo;
	}

    protected function placeOrder(Request $request) {
		$result = $this->orderRepo->store($request->all());

		return $result
			? response()->json(['message' => 'Order placed successfully'])
			: reponse()->json(['message' => 'Something went wrong.'], 400);
	}

	protected function getCustomerOrders() {
		return response()->json($this->orderRepo->getCustomerOrders());
	}

	protected function getEmployeeOrders() {
		return response()->json($this->orderRepo->getEmployeeOrders());
	}

	protected function toggleStatus($order_id) {
		$result = $this->orderRepo->toggleStatus($order_id);

		if($result) {
			return response()->json(['message' => 'Order status toggled.']);
		}

		return response()->json(['message' => 'Unable to toggle order status']);
	}
}
