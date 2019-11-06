<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface {
	function store(array $data): bool;
}
