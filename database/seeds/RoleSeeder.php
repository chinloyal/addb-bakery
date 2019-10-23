<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$admin = 'admin';
		$customer = 'customer';
		$employee = 'employee';

        $roles = [
			[
				'name' => $admin,
				'slug' => Str::slug($admin)
			],
			[
				'name' => $customer,
				'slug' => Str::slug($customer)
			],
			[
				'name' => $employee,
				'slug' => Str::slug($employee)
			]
		];

		foreach($roles as $role)
			Role::create($role);
    }
}
