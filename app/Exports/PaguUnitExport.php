<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class PaguUnitExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, WithEvents
{
    protected $paguUnit;
    protected $paguLembaga;
    protected $countData;

    public function __construct($paguLembaga, $paguUnit)
    {
        $this->paguUnit = $paguUnit;
        $this->paguLembaga = $paguLembaga;
        $this->countData = 0;
    }
    public function startCell(): string
    {
        return 'A5';
    }
    public function collection()
    {
        $paguUnits = $this->paguUnit;
        $exportData = collect();
        $i = 1;

        foreach ($paguUnits as $units) {
            $dataPush = [
                $i, '',
                $units->name,
                $units->paguUnit[0]->nominal ?? 0,
            ];
            $i++;
            $this->countData++;
            $exportData->push($dataPush);
        }
        return $exportData;
    }


    public function headings(): array
    {
        return [
            'No',
            '',
            'Nama',
            'Pagu',
        ];
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $w1 = 20;
                $w2 = 10;
                $w3 = 6;
                $w = [10, 2, 40, 20];
                $sheet->getColumnDimension('A')->setWidth($w[0]);
                $sheet->getColumnDimension('B')->setWidth($w[1]);
                $sheet->getColumnDimension('C')->setWidth($w[2]);
                $sheet->getColumnDimension('D')->setWidth($w[3]);

                $i = 5;
                $sheet->setCellValue('A1', 'Tahun');
                $sheet->setCellValue('A2', 'Pagu');
                $sheet->setCellValue('A3', 'Update');
                $sheet->setCellValue('B1', ':');
                $sheet->setCellValue('B2', ':');
                $sheet->setCellValue('B3', ':');

                $sheet->mergeCells('A5:B5');

                $sheet->setCellValue('C1', $this->paguLembaga->year);
                $sheet->setCellValue('C2', 'Rp ' . number_format($this->paguLembaga->nominal));
                $sheet->setCellValue('C3', $this->paguLembaga->updated_at);
                $event->sheet->getDefaultRowDimension()->setRowHeight(15);
                $styleCentered = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];
                $styleCenterBold = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ];
                $cellRange = 'A' . $i . ':D' . $i; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleCenterBold);
                $event->sheet->getDelegate()->getStyle('A' . $i . ':A' . ($i + $this->countData))->applyFromArray($styleCentered);
                $styleArray = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                ];
                $i = $j  = $k = $l = $m = $n = $o = 6;
                $total = 0;
                foreach ($this->paguUnit as $units) {
                    $total +=   $units->paguUnit[0]->nominal ?? 0;
                    $sheet->mergeCells('A' . $i . ':B' . $i);
                    $i++;
                }
                $sheet->mergeCells('A' . $i . ':C' . $i);
                $sheet->setCellValue('A' . $i, 'TOTAL');
                $sheet->setCellValue('D' . $i, $total);
                $event->sheet->getDelegate()->getStyle('A' . $i)->applyFromArray($styleCenterBold);
                $red = [
                    'fill' => [

                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'f56969']
                    ]
                ];
                if ($total != $this->paguLembaga->nominal) {
                    $event->sheet->getDelegate()->getStyle('C2')->applyFromArray($red);
                    $event->sheet->getDelegate()->getStyle('D' . $i)->applyFromArray($red);
                }
                // $styleArray = [
                //     'alignment' => [
                //         'wrapText' => true,
                //         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                //     ],
                // ];
                // $cellRange = 'A7:O' . $n - 1; // All headers
                // $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                // $event->sheet->getDelegate()->getStyle('K5:M' . $n - 1)->applyFromArray([
                //     'alignment' => [
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                //     ],
                // ]);

                // $event->sheet->getDelegate()->getStyle('F7:F' . $n - 1)->applyFromArray([
                //     'alignment' => [
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                //     ],
                // ]);
                // $event->sheet->getDelegate()->getStyle('H7:H' . $n - 1)->applyFromArray([
                //     'alignment' => [
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                //     ],
                // ]);


                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $cellRange = 'A5:D' . 5 + $this->countData + 1;
                $formatRp = '_-Rp* #.##0_-;-Rp* #.##0_-;_-Rp* "-"_-;_-@_-';
                $formatNumber = '#,##0_-';
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('D6:O' .  6 + $this->countData)->getNumberFormat()->setFormatCode($formatNumber);
                $event->sheet->getDelegate()->getStyle('C2')->getNumberFormat()->setFormatCode($formatNumber);
                $styleLeft = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        // 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_,
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('C1:C2')->applyFromArray($styleLeft);
            },
        ];
    }
    public function styles($sheet)
    {
        // $lastRow = count(RenstraMission::getWithDipa($this->dipaId));

        // Merge cell untuk kolom Title
        // $sheet->mergeCells('A4:A' . ($lastRow + 3));

        // Tambahkan style lainnya sesuai kebutuhan
        // Contoh: $sheet->getStyle('A4')->getAlignment()->setWrapText(true);

        return [
            // Tambahkan style lainnya sesuai kebutuhan
        ];
    }
}
