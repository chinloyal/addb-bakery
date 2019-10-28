<?php
namespace App\Repositories\Contracts;

use App\Models\{User, Permission};

interface AuthRepositoryInterface {
	function givePermission(Permission $permission, User $user): bool;

	function revokePermission(Permission $permission, User $user): bool;

	function togglePermission(int $permission_id, int $user_id): bool;

	function allPermissions();

	function employeePermissions();

	function getUserPermissions(int $user_id);
}
