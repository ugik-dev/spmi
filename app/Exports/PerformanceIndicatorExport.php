<?php

namespace App\Exports;

use App\Models\PerformanceIndicator;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PerformanceIndicatorExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    private $rowCount = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return PerformanceIndicator::query()->with('programTarget');
    }

    /**
     * Map data for each row.
     *
     * @param mixed $mission
     * @return array
     */
    public function map($indicator): array
    {
        $this->rowCount++;
        return [
            $this->rowCount,
            $indicator->programTarget->name,
            $indicator->name,
            $indicator->value,
        ];
    }

    /**
     * Return headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return ["No.", "Sasaran Program", "Indikator Kinerja", "Target"];
    }
}
