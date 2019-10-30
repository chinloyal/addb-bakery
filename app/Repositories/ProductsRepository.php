<?php
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductsRepositoryInterface;

class ProductsRepository implements ProductsRepositoryInterface {
	public function retrieveAll()
	{
		return Product::all();
	}

	public function store(array $productData): Product
	{
		return Product::create([
			'code' => $productData['code'],
			'name' => $productData['name'],
			'unit_cost' => $productData['unit_cost'],
			'current_quantity' => $productData['current_quantity']
		]);
	}

	public function update(int $id, array $productData): bool
	{
		$product = Product::find($id);

		$product->code = $productData['code'];
		$product->name = $productData['name'];
		$product->current_quantity = $productData['current_quantity'];
		$product->unit_cost = $productData['unit_cost'];

		$product->saveOrFail();
		return true;
	}

	public function delete($id): bool
	{
		try {
			$product = Product::find($id);

			if (!filled($product))
				return false;

			$product->delete();
			return true;
		} catch (\Exception $e) {
			return false;
		}
	}
}
