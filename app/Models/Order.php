<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	public $timestamps = false;

	protected $dates = [
		'delivery_date', 'time_of_placement'
	];

	protected $casts = [
		'completed' => 'boolean'
	];

	public function products(){
		return $this->belongsToMany(Product::class);
	}

	public function employee() {
		return $this->belongsTo(Employee::class);
	}

	public function customer() {
		return $this->belongsTo(User::class, 'customer_id');
	}

	public function toggleComplete() {
		$this->completed = !$this->completed;
		$this->save();
	}
}
