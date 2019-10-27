<?php

namespace App\Models;

use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
	];

	public $timestamps = false;

	public function userable(){
		return $this->morphTo();
	}

	public function cando(string $permission_name): bool {
		$permission_name = Str::slug($permission_name);
		return !filled($this->permissions()->where('slug', $permission_name)->first());
	}

	public function inRole($role_name): bool {
		if (is_string($role_name)) {
			$role_name = Str::slug($role_name);

			return $this->role->slug == $role_name;
		} elseif(is_array($role_name)) {
			return in_array($this->role->slug, $role_name);
		}

		return false;
	}

	public function permissions(){
		return $this->belongsToMany(Permission::class);
	}

	public function role(){
		return $this->belongsTo(Role::class);
	}

	public function getFullNameAttribute(){
		return $this->first_name . ' ' . $this->last_name;
	}
}
