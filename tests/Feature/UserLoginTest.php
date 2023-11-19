<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Spatie\Permission\Models\Role;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_are_redirected_to_respective_dashboards_on_login()
    {
        $roles = ['admin', 'prodi', 'auditor'];

        foreach ($roles as $roleName) {
            // Create a role
            $role = Role::create(['name' => $roleName]);

            // Create a user with the role
            $user = factory(User::class)->create([
                'email' => $roleName . '@example.com',
                'password' => bcrypt($roleName . 'Password')
            ]);
            $user->assignRole($role);

            // Attempt to log in
            $response = $this->post('/proses', [
                'email' => $roleName . '@example.com',
                'password' => $roleName . 'Password',
            ]);

            // Assert redirected to the respective dashboard
            $response->assertRedirect('/' . $roleName . '/dashboard');
        }
    }
    /** @test */
    public function user_without_role_is_redirected_to_403_on_login()
    {
        // Create a user without any roles
        $user = factory(User::class)->create([
            'email' => 'user@example.com',
            'password' => bcrypt('userPassword')
        ]);

        // Attempt to log in as the user
        $response = $this->post('/proses', [
            'email' => 'user@example.com',
            'password' => 'userPassword',
        ]);

        // Assert redirected to a 403 page
        $response->assertStatus(403);
    }
}
