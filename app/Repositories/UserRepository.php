<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\{ User, Individual, Corporate };

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

		if($type == 'individual') {
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
		}else if ($type == 'corporate') {
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

			return true;
		}

		return false;
	}
}
