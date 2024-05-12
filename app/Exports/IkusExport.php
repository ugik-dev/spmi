<?php

namespace App\Exports;

use App\Models\RenstraIndicator;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IkusExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return RenstraIndicator::with('mission')->get();
    }

    /**
     * Map data for each row.
     *
     * @param mixed $mission
     * @return array
     */
    public function map($ikus): array
    {
        return [
            $ikus->id,
            $ikus->mission->description, // Asumsi bahwa model mission memiliki field 'description'
            $ikus->description
        ];
    }

    /**
     * Return headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return ["No", "Misi", "SASARAN PROGRAM"];
    }
}
