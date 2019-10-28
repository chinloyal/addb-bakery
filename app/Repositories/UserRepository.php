<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\{ User, Individual, Corporate, Employee};
use Illuminate\Auth\Events\Verified;

class UserRepository implements UserRepositoryInterface {
	const ADMIN = 1;
	const CUSTOMER = 2;
	const EMPLOYEE = 3;

	public function store($userData, $type): bool {
		$user = new User();

		$user->first_name = $userData['first_name'];
		$user->last_name = $userData['last_name'];
		$user->email = $userData['email'];
		$user->password = bcrypt($userData['password']);

		switch ($type) {
			case 'individual':
				return $this->storeIndividual($user, $userData);
				break;
			case 'corporate':
				return $this->storeCorporate($user, $userData);
				break;
			case 'employee':
				return $this->storeEmployee($user, $userData);
				break;
			default:
				return false;
				break;
		}

		return false;
	}

	private function storeIndividual(User &$user, $userData): bool {
		$user->role_id = self::CUSTOMER;

		$individual = new Individual();
		$individual->dob = $userData['dob'];

		$user->user_type = Individual::class;

		$user->saveOrFail();
		$individual->user_id = $user->id;

		$individual->user()->save($user);
		$individual->saveOrFail();

		# Need to save userable_id again after save
		# because id is generated after save.
		$user->userable_id = $individual->id;
		$user->saveOrFail();

		return true;
	}

	private function storeCorporate(User &$user, $userData): bool {
		$user->role_id = self::CUSTOMER;

		$corporate = new Corporate();
		$corporate->business_name = $userData['business_name'];
		$corporate->trn = $userData['trn'];

		$user->user_type = Corporate::class;

		$user->saveOrFail();
		$corporate->user_id = $user->id;

		$corporate->user()->save($user);
		$corporate->saveOrFail();

		# Need to save userable_id again after save
		# because id is generated after save.
		$user->userable_id = $corporate->id;
		$user->saveOrFail();

		if ($user->markEmailAsVerified()) {
			event(new Verified($user));
		}
		return true;
	}

	private function storeEmployee(User &$user, $userData): bool {
		$user->role_id = self::EMPLOYEE;

		$employee = new Employee();
		$employee->trn = $userData['trn'];
		$employee->address = $userData['address'];

		$user->user_type = Employee::class;

		$user->saveOrFail();
		$employee->user_id = $user->id;

		$employee->user()->save($user);
		$employee->saveOrFail();

		# Need to save userable_id again after save
		# because id is generated after save.
		$user->userable_id = $employee->id;
		$user->saveOrFail();

		return true;
	}
	/**
	 * Used to manually verify email
	 *
	 * @param string $email
	 */
	public function verifyEmail($email) {
		$user = User::where('email', $email)->first();

		if(empty($user))
			return;

		if ($user->markEmailAsVerified()) {
			event(new Verified($user));
		}
	}

	public function allEmployees() {
		return Employee::with('user')->get();
	}
}
