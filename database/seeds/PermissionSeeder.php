<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $permissions = [
      'create user' => ['admin'],
      'create prodi' => ['admin'],
      'create criterion' => ['admin'],
      'create faculty' => ['admin'],
      'create indicator' => ['admin'],
      'create assesment' => ['admin'],
      'create degree' => ['admin'],
      'create period' => ['admin'],

      'edit user' => ['admin'],
      'edit prodi' => ['admin'],
      'edit criterion' => ['admin'],
      'edit faculty' => ['admin'],
      'edit indicator' => ['admin'],
      'edit assesment' => ['admin'],
      'edit degree' => ['admin'],
      'edit period' => ['admin'],

      'delete user' => ['admin'],
      'delete prodi' => ['admin'],
      'delete criterion' => ['admin'],
      'delete faculty' => ['admin'],
      'delete indicator' => ['admin'],
      'delete assesment' => ['admin'],
      'delete degree' => ['admin'],
      'delete period' => ['admin'],

      'see users' => ['admin'],
      'see user' => ['admin'],
      'see prodis' => ['admin', 'auditor'],
      'see criteria' => ['admin', 'auditor'],
      'see faculties' => ['admin', 'auditor'],
      'see indicators' => ['admin', 'auditor'],
      'see assesments' => ['admin', 'auditor'],
      'see degrees' => ['admin', 'auditor'],
      'see period' => ['admin', 'auditor'],

      'scoring assesment' => ['auditor'],
      'comment document' => ['auditor'],
      'upload document' => ['prodi'],
    ];

    foreach ($permissions as $permissionName => $roles) {
      $permission = Permission::firstOrCreate(['name' => $permissionName]);

      foreach ($roles as $roleName) {
        $role = Role::firstOrCreate(['name' => $roleName]);
        $role->givePermissionTo($permission);
      }
    }
  }
}
