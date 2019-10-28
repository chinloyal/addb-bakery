<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	protected $fillable = [
		'trn', 'address'
	];

	public $timestamps = false;

	public function user() {
		return $this->belongsTo(User::class);
	}
}
