<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\IngredientsRepositoryInterface;

class IngredientController extends Controller
{
	protected $ingredientsRepo;

	public function __construct(IngredientsRepositoryInterface $ingredientsRepo){
		// $this->middleware(['cando' => 'Manage Ingredients']);

		$this->ingredientsRepo = $ingredientsRepo;
	}

	protected function retrieveAll() {
		return $this->ingredientsRepo->retrieveAll();
	}

	protected function store(Request $request) {
		$this->validateRequest($request);

		$result = $this->ingredientsRepo->store($request->all());

		return response()->json($result);
	}

	protected function update($id, Request $request){
		$this->validateRequest($request);

		$result = $this->ingredientsRepo->update($id, $request->all());

		return $result
		? response()->json(['message' => 'Ingredient updated successfully.'])
		: response()->json(['message' => 'Something went wrong.'], 400);
	}

	protected function destroy($id) {
		if(is_numeric($id)){
			$result = $this->ingredientsRepo->delete($id);

			return $result
			? response()->json(['message' => 'Ingredient deleted successfully.'])
			: response()->json(['message' => 'Unable to delete ingredient.'], 400);
		}else {
			return response()->json(['message' => 'Nothing to delete.'], 400);
		}
	}

	private function validateRequest(Request $request) {
		$this->validate($request, [
			'name' => 'required|string|min:2',
			'measurement_unit' => 'required|string|min:2',
			'current_quantity' => 'required|numeric'
		]);
	}
}
