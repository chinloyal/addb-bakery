<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	public $timestamps = false;

	public function role(){
		return $this->belongsTo(Role::class);
	}

	public function users() {
		return $this->belongsToMany(User::class);
	}

	public function give(User $user){
		$this->users()->attach($user->id);
	}

	public function revoke(User $user) {
		$this->users()->detach($user->id);
	}
}
