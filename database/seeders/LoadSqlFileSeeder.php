<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoadSqlFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filepaths =
            [
                database_path('seeders/sql/institutions_degrees.sql'),
                database_path('seeders/sql/faculties.sql'),
                database_path('seeders/sql/study_programs.sql'),
                database_path('seeders/sql/kriteria.sql'),
                database_path('seeders/sql/indikators.sql'),
                // database_path('seeders/sql/elements.sql'),
            ];

        foreach ($filepaths as $sqlFilePath) {
            // Check if the file exists
            if (file_exists($sqlFilePath)) {
                $sqlContent = file_get_contents($sqlFilePath);
                DB::unprepared($sqlContent);
                echo "SQL Success at $sqlFilePath\n";
            } else {
                echo "SQL file not found at $sqlFilePath\n";
            }
        }
    }
}
