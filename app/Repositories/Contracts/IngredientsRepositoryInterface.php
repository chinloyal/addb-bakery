<?php

namespace App\Repositories\Contracts;

use App\Models\Ingredient;

interface IngredientsRepositoryInterface {
	function retrieveAll();

	function store(array $ingredientData): Ingredient;

	function update(int $id, array $ingredientData): bool;

	function delete(int $id): bool;
}
