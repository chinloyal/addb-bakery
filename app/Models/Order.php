<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	public $timestamps = false;

	protected $dates = [
		'delivery_date'
	];

	public function products(){
		return $this->belongsToMany(Product::class);
	}
}
