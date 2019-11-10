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

	/**
	 * Get the current employee logged in orders
	 * @return Illuminate\Support\Collection
	 */
	function getEmployeeOrders(): Collection;

	/**
	 * Set the status of the order to complete or incomplete
	 * @param int
	 * @return bool
	 */
	function toggleStatus(int $order_id): bool;
}
