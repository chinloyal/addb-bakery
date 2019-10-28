<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Http\Request;

class AuthController extends Controller {
	protected $authRepo;

	public function __construct(AuthRepositoryInterface $authRepo) {
		$this->authRepo = $authRepo;
	}

	protected function togglePermission($permission_id, Request $request){
		if(is_numeric($permission_id) and is_numeric($request->user_id)){
			$result = $this->authRepo->togglePermission($permission_id, $request->user_id);

			if ($result) {
				return response()->json(['message' => 'Permission toggled.']);
			}
		}

		return response()->json(['message' => 'Unable to toggle permission.'], 400);
	}

	protected function allPermissions() {
		return $this->authRepo->allPermissions();
	}

	protected function employeePermissionView($user_id) {
		$userPermissions = $this->authRepo->getUserPermissions($user_id);

		return view('dashboard.admin.permissions', [
			'user_permissions' => $userPermissions,
			'user_id' => $user_id
		]);
	}
}
