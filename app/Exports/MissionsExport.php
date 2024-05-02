<?php

namespace App\Exports;

use App\Models\RenstraMission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MissionsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RenstraMission::all();
    }

    /**
     * Map data for each row.
     *
     * @param mixed $mission
     * @return array
     */
    public function map($mission): array
    {
        return [
            $mission->id,
            $mission->description
        ];
    }

    /**
     * Return headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return ["No", "Misi"];
    }
}
