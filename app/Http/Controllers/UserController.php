<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserController extends Controller {
	protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo) {
		$this->userRepo = $userRepo;
	}

	public function allEmployees() {
		return $this->userRepo->allEmployees();
	}

	protected function storeEmployee(Request $request) {
		$employeeData = [
			'trn' => $request->trn,
			'address' => $request->address,
			'first_name' => $request->user['first_name'],
			'last_name' =>  $request->user['last_name'],
			'email' => $request->user['email'],
			'password' => hash('adler32', time())
		];

		$validator = $this->validator($employeeData);

		if ($validator->fails())
			return response()->json([
				'messages' => $validator->errors()->all()
			], 400);

		$result = $this->userRepo->store($employeeData, 'employee');

		if($result){
			return response()->json(['message' => 'Employee added successfully.']);
		}else{
			return response()->json(['message' => 'Unable to create employee'], 400);
		}

	}

	/**
	 * Get a validator for an incoming request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data){
		return Validator::make($data, [
			'first_name' => ['required', 'string', 'min:2'],
			'last_name' => ['required', 'string', 'min:2'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'address' => ['required', 'string'],
			'trn' => ['required', 'min:9', 'max:11', 'unique:employees']
		]);
	}
}
