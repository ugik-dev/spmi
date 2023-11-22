<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $roles = ['admin', 'prodi', 'auditor'];

    foreach ($roles as $roleName) {
      Role::firstOrCreate(['name' => $roleName]);
    }
  }
}
