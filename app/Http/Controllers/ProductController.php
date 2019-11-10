<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Repositories\Contracts\ProductsRepositoryInterface;

class ProductController extends Controller
{
	protected $productsRepo;

	public function __construct(ProductsRepositoryInterface $productsRepo)
	{
		$this->middleware('cando:Manage Products')->except('retrieveAll');

		$this->productsRepo = $productsRepo;
	}

	protected function retrieveAll()
	{
		return $this->productsRepo->retrieveAll();
	}

	protected function store(Request $request)
	{
		$this->validateRequest($request);

		$result = $this->productsRepo->store($request->all());

		return response()->json($result);
	}

	protected function update($id, Request $request)
	{
		$this->validateRequest($request);

		$result = $this->productsRepo->update($id, $request->all());

		return $result
			? response()->json(['message' => 'Product updated successfully.'])
			: response()->json(['message' => 'Something went wrong.'], 400);
	}

	protected function destroy($id)
	{
		if (is_numeric($id)) {
			$result = $this->productsRepo->delete($id);

			return $result
				? response()->json(['message' => 'Product deleted successfully.'])
				: response()->json(['message' => 'Unable to delete Product.'], 400);
		} else {
			return response()->json(['message' => 'Nothing to delete.'], 400);
		}
	}

	protected function assignIngredients($id, Request $request) {
		$result = $this->productsRepo->updateIngredients($id, $request->all());

		return $result
			? response()->json(['message' => 'Ingredients assigned successfully.'])
			: response()->json(['message' => 'Unable to assign ingredients to product.'], 400);
	}

	private function validateRequest(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|string|min:2',
			'code' => 'required|string|min:4|' . Rule::unique('products')->ignore($request->id),
			'current_quantity' => 'required|numeric|min:0',
			'unit_cost' => 'required|numeric|min:0'
		]);
	}
}
