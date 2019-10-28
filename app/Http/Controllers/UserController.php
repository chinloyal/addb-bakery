<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller {
	protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo) {
		$this->userRepo = $userRepo;
	}

	public function allEmployees() {
		return $this->userRepo->allEmployees();
	}
}
