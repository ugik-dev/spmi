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
    $this->adminUser = factory(User::class)->create()->assignRole($this->role);
  }

  private function createUser($isAdmin = false)
  {
    $user = factory(User::class)->create();
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

  public function testAdminCanDeleteUser()
  {
    $userToDelete = $this->createUser();

    $response = $this->actingAs($this->adminUser)->delete(route('users.delete', $userToDelete->id));
    $response->assertRedirect();
    $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
  }

  public function testAdminCanViewUserDetails()
  {
    $user = $this->createUser();

    $response = $this->actingAs($this->adminUser)->get(route('users.detail', $user->id));
    $response->assertStatus(200)->assertJson([
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
    ]);
  }

  public function testAdminReceivesNotFoundForNonExistentUserDetails()
  {
    $response = $this->actingAs($this->adminUser)->get(route('users.detail', 99999));
    $response->assertStatus(404);
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

  public function testNonAdminCannotViewUserDetails()
  {
    $nonAdminUser = $this->createUser();
    $userToView = $this->createUser();

    $response = $this->actingAs($nonAdminUser)->get(route('users.detail', $userToView->id));
    $response->assertForbidden();
  }

  public function testNonAdminReceivesNotFoundForNonExistentUserDetails()
  {
    $nonAdminUser = $this->createUser();

    $response = $this->actingAs($nonAdminUser)->get(route('users.detail', 99999));
    $response->assertStatus(404);
  }
}
