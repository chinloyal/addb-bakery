<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\Contracts\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
	public function allPermissions() {
		return Permission::only(['id', 'name'])->all();
	}

	public function employeePermissions() {
		return Role::getEmployee()->permissions()->get();
	}

	public function getUserPermissions(int $user_id) {
		$user = User::findOrFail($user_id);
		return Role::getEmployee()->permissions->map(function($permission) use ($user){
			$permission->cando = $user->cando($permission->name);

			return $permission;
		});
	}

	public function givePermission(Permission $permission, User $user): bool {
		if(filled($permission)){
			$permission->give($user);
			return true;
		}

		return false;
	}

	public function revokePermission(Permission $permission, User $user): bool {

		if (filled($permission)) {
			$permission->revoke($user);
			return true;
		}

		return false;
	}

	public function togglePermission(int $permission_id, int $user_id): bool {
		$permission = Permission::find($permission_id);
		$user = User::find($user_id);

		if(filled($permission) and filled($user)) {
			if($user->cando($permission->name)){
				$this->revokePermission($permission, $user);
				return true;
			} else {
				$this->givePermission($permission, $user);
				return true;
			}
		}

		return false;
	}
}
