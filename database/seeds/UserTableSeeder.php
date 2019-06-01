<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $employee = new User();
        $employee->name = 'Admin';
        $employee->email = 'andleex@gmail.com';
        $employee->password = bcrypt('secret');
        $employee->save();

        $employee->roles()->attach($adminRole);


        $manager = new User();
        $manager->name = 'Test User';
        $manager->email = 'manager@example . com';
        $manager->password = bcrypt('secret');
        $manager->save();
        $manager->roles()->attach($userRole);
    }
}
