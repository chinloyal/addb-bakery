<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
	protected $fillable = ['dob'];

	public $timestamps = false;

	public function user() {
		return $this->morphOne(User::class, 'userable', 'user_type');
	}
}
