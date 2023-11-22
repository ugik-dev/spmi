<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use Spatie\Permission\Models\Role;

class UserControllerTest extends TestCase
{
  use RefreshDatabase;

  protected $adminUser;
  protected $role;

  public function setUp(): void
  {
    parent::setUp();
    $this->role = Role::firstOrCreate(['name' => 'admin']);
    $this->adminUser = User::factory()->create()->assignRole($this->role);
  }

  private function createUser($isAdmin = false)
  {
    $user = User::factory()->create();
    if ($isAdmin) {
      $user->assignRole($this->role);
    }
    return $user;
  }

  public function testAdminCanEditUserSuccessfully()
  {
    $user = $this->createUser();

    $response = $this->actingAs($this->adminUser)->patch(route('users.edit', $user->id), [
      'name' => 'New Name',
      'email' => 'newemail@example.com',
      'role' => 'admin',
    ]);

    $response->assertRedirect()->assertSessionHas('success');
    $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'New Name']);
  }

  public function testAdminReceivesValidationErrorOnUserEdit()
  {
    $user = $this->createUser();

    $response = $this->actingAs($this->adminUser)->patch(route('users.edit', $user->id), [
      'email' => 'newemail@example.com',
      'role' => 'admin',
    ]);

    $response->assertSessionHasErrors(['name']);
  }

  public function testAdminReceivesNotFoundForNonExistentUserEdit()
  {
    $response = $this->actingAs($this->adminUser)->patch(route('users.edit', 99999), [
      'name' => 'New Name',
      'email' => 'newemail@example.com',
      'role' => 'admin',
    ]);

    $response->assertStatus(404);
  }

  public function testAdminCannotUpdateUserWithEmailAlreadyTaken()
  {
    // Create two users
    $user1 = $this->createUser();
    $user2 = $this->createUser();

    // Acting as the first user, try to update email to the second user's email
    $response = $this->actingAs($this->adminUser)->patch(route('users.edit', $user1->id), [
      'name' => $user1->name,
      'email' => $user2->email, // Use the email of user2 here
      'role' => 'admin',
      // other necessary fields...
    ]);

    // Assert that there are session errors for email field
    $response->assertSessionHasErrors(['email']);

    // Optional: Assert the user's email didn't change in the database
    $this->assertDatabaseHas('users', [
      'id' => $user1->id,
      'email' => $user1->email, // original email of user1
    ]);
  }

  public function testAdminCanDeleteUser()
  {
    $userToDelete = $this->createUser();

    $response = $this->actingAs($this->adminUser)->delete(route('users.delete', $userToDelete->id));
    $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    $response->assertStatus(200)->assertJson(['id' => $userToDelete->id]);
  }


  public function testNonAdminCannotEditUser()
  {
    $nonAdminUser = $this->createUser();
    $userToEdit = $this->createUser();

    $response = $this->actingAs($nonAdminUser)->patch(route('users.edit', $userToEdit->id), [
      'name' => 'Updated Name',
      'email' => 'updatedemail@example.com',
      'role' => 'admin',
    ]);

    $response->assertForbidden();
  }

  public function testNonAdminCannotDeleteUser()
  {
    $nonAdminUser = $this->createUser();
    $userToDelete = $this->createUser();

    $response = $this->actingAs($nonAdminUser)->delete(route('users.delete', $userToDelete->id));
    $response->assertForbidden();
  }
}
