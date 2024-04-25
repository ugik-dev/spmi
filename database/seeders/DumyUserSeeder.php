<?php

namespace Database\Seeders;

use App\Models\RenstraIndicator;
use App\Models\RenstraMission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DumyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $u = User::firstOrCreate([
            'name' => 'Super Adm',
            'email' => 'admin2@mail.com',

        ], ['password' => Hash::make('superAdmin123!.'),]);
        $u->assignRole('SUPER ADMIN PERENCANAAN');

        $u = User::firstOrCreate([
            'name' => 'PPK',
            'email' => 'ppk@mail.com',

        ], ['password' => Hash::make('123'),]);
        $u->assignRole('PPK');

        $u = User::firstOrCreate([
            'name' => 'Staff PPK',
            'email' => 'staff@mail.com',

        ], ['password' => Hash::make('123'),]);
        $u->assignRole('STAF PPK');

        $u = User::firstOrCreate([
            'name' => 'SPI',
            'email' => 'spi@mail.com',

        ], ['password' => Hash::make('123'),]);
        $u->assignRole('SPI');

        $u = User::firstOrCreate([
            'name' => 'BENDAHARA',
            'email' => 'bendahara@mail.com',

        ], ['password' => Hash::make('123'),]);
        $u->assignRole('BENDAHARA');

        $u = User::firstOrCreate([
            'name' => 'Pelaksana',
            'email' => 'pelaksana@mail.com',

        ], ['password' => Hash::make('123'),]);
        $u->assignRole('Pelaksana Kegiatan');

        $misi = ["Mengembangkan pendidikan yang unggul melalui pembelajaran inovatif berbasis teknologi informasi dan transformasi digital", "Menghasilkan riset dan publikasi ilmiah yang kompetitif standar nasional dan internasional", "Menghasilkan lulusan yang professional, berdaya saing secara global,  berwawasan keislaman, kebangsaan, dan kemanusian", "Meningkatkan pengabdian masyarakat yang berdampak pada budaya literasi, kesejahteraan dan religiusitas yang moderat", "Membangun tata kelola lembaga (Good University Governance) yang akuntabel, transparan sehingga menghasilkan pelayanan yang unggul bagi civitas academica dan masyarakat"];
        foreach ($misi as $m) {

            $r =  RenstraMission::create([
                'renstra_id' => 1,
                'description' => $m
            ]);

            for ($i = 1; $i <= 4; $i++) {
                RenstraIndicator::create([
                    'renstra_mission_id' => $r->id,
                    'description' => 'Text Renstra ' . $r->id . ' ke ' . $i
                ]);
            }
        }
    }
}
