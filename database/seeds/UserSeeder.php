<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
			'first_name' => 'John',
			'last_name' => 'Doe',
			'email' => 'johndoe@bakery.com',
			'password' => bcrypt('adminpassword'),
			'role_id' => Role::getAdmin()->id
		]);

		$employeeUser = User::create([
			'first_name' => 'Jane',
			'last_name' => 'Wright',
			'email' => 'jane@bakery.com',
			'password' => bcrypt('password'),
			'role_id' => Role::getEmployee()->id
		]);

		$employee = Employee::create([
			'user_id' => $employeeUser->id,
			'trn' => '123-456-789',
			'address' => '13 Bread Lane, Kingston 14'
		]);

		$employeeUser->userable_id = $employee->id;
		$employeeUser->user_type = Employee::class;
		$employeeUser->save();
    }
}
