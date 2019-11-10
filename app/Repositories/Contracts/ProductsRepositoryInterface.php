<?php
namespace App\Repositories\Contracts;

use App\Models\Product;


interface ProductsRepositoryInterface {
	function retrieveAll();

	function store(array $productData): Product;

	function update(int $id, array $productData): bool;

	function delete(int $id): bool;

	function updateIngredients(int $id, array $ingredientsIds): bool;
}
