<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Periode;

class PeriodeSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $d = [
            'name' => 'Tahun Ajaran 2023 2024',
            'periode_start' => date('2023-07-01'),
            'periode_end' => date('2024-02-29'),
            'prodi_start' => date('2023-07-01'),
            'prodi_end' => date('2024-02-29'),
            'auditor_start' => date('2023-07-01'),
            'auditor_end' => date('2024-02-29'),
            'revisi_start' => date('2023-07-01'),
            'revisi_end' => date('2024-02-29'),
        ];

        Periode::create($d);
    }
}
