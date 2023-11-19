<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a role of admin if it doesn't exist
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Create an admin user
        $admin = User::create([
            'name' => 'AMI',
            'email' => 'admin@mail.com',
            'password' => Hash::make('secret'),
        ]);

        // Assign admin role to the user
        $admin->assignRole($role);
    }
}
