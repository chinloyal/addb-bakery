<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
	protected $orderRepo;

	public function __construct(OrderRepositoryInterface $orderRepo){
		$this->orderRepo = $orderRepo;
	}

    protected function placeOrder(Request $request) {
		$result = $this->orderRepo->store($request->all());

		return $result
			? response()->json(['message' => 'Order placed successfully'])
			: reponse()->json(['message' => 'Something went wrong.'], 400);
	}
}
