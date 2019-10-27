<?php

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminPermissions = [
			'Manage Employees',
		];

		$employeePermissions = [
			'Manage Products',
			'Manage Ingredients',
			'Manage Orders'
		];

		foreach($adminPermissions as $permission){
			Permission::create([
				'name' => $permission,
				'slug' => Str::slug($permission),
				'role_id' => Role::where('slug', 'admin')->first()->id
			]);
		}


		foreach ($employeePermissions as $permisson) {
			Permission::create([
				'name' => $permisson,
				'slug' => Str::slug($permisson),
				'role_id' => Role::where('slug', 'employee')->first()->id
			]);
		}

    }
}
