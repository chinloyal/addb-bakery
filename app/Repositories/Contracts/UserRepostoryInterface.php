<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface {

	function store($userData, $type): bool;

	function allEmployees();
}
