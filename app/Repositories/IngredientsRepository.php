<?php

namespace App\Repositories;

use App\Models\Ingredient;
use App\Repositories\Contracts\IngredientsRepositoryInterface;

class IngredientsRepository implements IngredientsRepositoryInterface {
	public function retrieveAll() {
		return Ingredient::all();
	}

	public function store(array $ingredientData): Ingredient {
		return Ingredient::create([
			'name' => $ingredientData['name'],
			'measurement_unit' => $ingredientData['measurement_unit'],
			'current_quantity' => $ingredientData['current_quantity'],
			'reorder_level' => 'L'
		]);
	}

	public function update(int $id, array $ingredientData): bool {
		$ingredient = Ingredient::find($id);

		$ingredient->name = $ingredientData['name'];
		$ingredient->measurement_unit = $ingredientData['measurement_unit'];
		$ingredient->current_quantity = $ingredientData['current_quantity'];

		$ingredient->saveOrFail();
		return true;
	}

	public function delete($id): bool {
		try {
			$ingredient = Ingredient::find($id);

			if(!filled($ingredient))
				return false;

			$ingredient->delete();
			return true;
		}catch(\Exception $e) {
			return false;
		}
	}
}
