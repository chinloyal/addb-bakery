<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
		'name', 'code', 'current_quantity', 'unit_cost'
	];

	public $timestamps = false;

	public function ingredients() {
		return $this->belongsToMany(Ingredient::class);
	}
}
