<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface OrderRepositoryInterface {
	function store(array $data): bool;

	/**
	 * Get the current customer logged in orders
	 * @return Illuminate\Support\Collection
	 */
	function getCustomerOrders(): Collection;
}
