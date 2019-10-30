<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
	protected $fillable = [
		'name', 'measurement_unit', 'current_quantity', 'reorder_level'
	];

	public $timestamps = false;
}
