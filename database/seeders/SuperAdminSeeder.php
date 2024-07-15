<?php

namespace Database\Seeders;

use App\Models\RenstraIndicator;
use App\Models\RenstraMission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $u = User::find(1);
        // dd($u);
        $u->assignRole('SUPER ADMIN PERENCANAAN');
    }
    // php artisan db:seed --class=SuperAdminSeeder
}
