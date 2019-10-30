<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	public $timestamps = false;
	const ADMIN = 'admin';
	const EMPLOYEE = 'employee';
	const CUSTOMER = 'customer';

	public function permissions() {
		return $this->hasMany(Permission::class);
	}

	public static function getAdmin() {
		return Role::where('slug', self::ADMIN)->first();
	}

	public static function getEmployee() {
		return Role::where('slug', self::EMPLOYEE)->first();
	}

	public static function getCustomer() {
		return Role::where('slug', self::CUSTOMER)->first();
	}
}
