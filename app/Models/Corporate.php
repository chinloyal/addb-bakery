<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corporate extends Model
{
	protected $fillable = ['business_name', 'trn'];

	public $timestamps = false;

    public function user() {
		return $this->morphOne(User::class, 'userable', 'user_type');
	}
}
