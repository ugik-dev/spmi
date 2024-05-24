<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DipaReportFa implements FromCollection, WithHeadings, WithStyles,  WithCustomStartCell, WithEvents
{
    protected $dataBI;
    protected $dipa;
    protected $pagu;
    protected $total_row;

    public function __construct($dataBI, $dipa, $pagu)
    {
        $this->dataBI = $dataBI;
        $this->dipa = $dipa;
        $this->pagu = $pagu;
        $this->total_row = 7;
    }
    public function startCell(): string
    {
        return 'A7';
    }

    public function collection()
    {

        $dataBI = $this->dataBI;

        $exportData = collect();
        // $sheet = Excel::sheet();
        // $i = 4;
        $collectionData = [];
        $arr_key = 0;
        foreach ($dataBI as $accountGroups) {
            // $rowspanMisi = count($misi['child_missi']);
            $rowspanIKU = 0; // Jumlah row untuk SASARAN PROGRAM
            $rowspanSasaran = 0; // Jumlah row untuk Sasaran
            $rowspanIndPerkin = 0; // Jumlah row untuk Ind Perkin
            $rowspanActivity = 0; // Jumlah row untuk Activity
            $isActivityDisplayed = false;
            foreach ($accountGroups as $accountCode => $budgetImplementations) {
                if (!$isActivityDisplayed) {
                    $dataPush = [
                        $budgetImplementations->first()->activity->code, '',
                        $budgetImplementations->first()->activity->name,  '', '', '',
                        $budgetImplementations->first()->activity_total_sum
                    ];
                    for ($for_i = 1; $for_i < 15; $for_i++) {
                        $dataPush[] = 0;
                    }
                    $keyS1S = $arr_key;
                    $collectionData[] = $dataPush;
                    $arr_key++;
                    $this->total_row++;
                    $isActivityDisplayed = true;
                }

                foreach ($budgetImplementations as $budgetImplementation) {
                    if ($budgetImplementation->accountCode) {
                        $dataPush = [
                            $budgetImplementation->accountCode->code, '',
                            $budgetImplementation->accountCode->name,
                            '',
                            '', '',
                            $budgetImplementations->first()->account_total_sum
                        ];
                        for ($for_i = 1; $for_i < 15; $for_i++) {
                            $dataPush[] = 0;
                        }
                        $keyS2S = $arr_key;
                        $collectionData[] = $dataPush;
                        // $exportData->push($dataPush);
                        $arr_key++;
                        $this->total_row++;
                    }
                    foreach ($budgetImplementation->details as $detail) {
                        if ($detail) {
                            $res = [];
                            if (count($detail->receiptItems) > 0) {
                                $res = $detail->counter($detail->id, $this->dipa->year);
                            };
                            $tmp_push = [
                                '', '',
                                $detail->name,
                                $detail->volume,
                                $detail->expenditureUnit->code,
                                $detail->price,
                                $detail->total,
                            ];
                            $realisasi = 0;
                            $realisasi = 0;
                            for ($for_i = 1; $for_i < 13; $for_i++) {
                                if (!empty($res[$for_i])) {
                                    $tmp_push[] = $res[$for_i]->amount;
                                    $collectionData[$keyS2S][$for_i + 6] += $res[$for_i]->amount;
                                    $collectionData[$keyS1S][$for_i + 6] += $res[$for_i]->amount;
                                    $realisasi += $res[$for_i]->amount;
                                } else  $tmp_push[] = '';
                                // dd($exportData[$keyS2S][7]);
                            }
                            $tmp_push[] = $realisasi;
                            $tmp_push[] = $detail->total - $realisasi;
                            $collectionData[$keyS2S][19] += $realisasi;
                            $collectionData[$keyS2S][20] += $detail->total - $realisasi;
                            $collectionData[$keyS1S][19] += $realisasi;
                            $collectionData[$keyS1S][20] += $detail->total - $realisasi;
                            // $realisasi += $res[$for_i]->amount;

                            $dataPush =  $tmp_push;
                            $collectionData[] =   $dataPush;
                            $arr_key++;

                            // $exportData->push($dataPush);
                            $this->total_row++;
                        }
                    }
                }
            }
        }
        $exportData->push($collectionData);

        return $exportData;
    }


    public function headings(): array
    {
        return [
            // 'Misi',
            // 'SASARAN PROGRAM',
            // 'Sasaran',
            // 'Indikator',
            // 'Kode',
            // 'Deskripsi',
            // 'Kode',
            // 'Deskripsi',
            // 'Kegiatan', // Kosong untuk memberikan ruang
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
                $w = [12, 2, 25, 10, 10, 10, 14];
                for ($i = 1; $i < 13; $i++) {
                    $w[] = 10;
                }
                $w[] = 14;
                $w[] = 2;
                $w[] = 14;


                foreach ($w as $keyW => $ws) {
                    $curRow = $this->numberToLetter($keyW + 1);
                    $sheet->getColumnDimension($curRow)->setWidth($w[$keyW]);
                }
                // $sheet->getColumnDimension('I')->setWidth($w[8]);
                // $sheet->getColumnDimension('J')->setWidth($w[9]);
                // $sheet->getColumnDimension('K')->setWidth($w[10]);
                $i = 5;


                $sheet->mergeCells('A' . $i . ':C' . $i);
                $sheet->mergeCells('A' . ($i + 1) . ':B' . ($i + 1));
                // $sheet->mergeCells('D' . $i . ':E' . $i);
                // $sheet->mergeCells('F' . $i . ':F' . $i + 1);
                // $sheet->mergeCells('G' . $i . ':G' . $i + 1);
                $sheet->mergeCells('U' . $i . ':V' . $i + 1);
                $sheet->mergeCells('T' . $i . ':T' . $i + 1);
                $sheet->mergeCells('D' . $i . ':D' . $i + 1);
                $sheet->mergeCells('E' . $i . ':E' . $i + 1);
                $sheet->mergeCells('F' . $i . ':F' . $i + 1);
                $sheet->mergeCells('G' . $i . ':G' . $i + 1);

                $sheet->setCellValue('A1', 'Unit Kerja');
                $sheet->setCellValue('A2', 'Keterangan');
                $sheet->setCellValue('A3', 'Petugas');

                $sheet->setCellValue('T1', 'Tanggal');
                $sheet->setCellValue('T2', 'Pagu Unit Kerja');
                $sheet->setCellValue('T3', 'Total Usulan');
                $sheet->setCellValue('U1', ':');
                $sheet->setCellValue('U2', ':');
                $sheet->setCellValue('U3', ':');
                $sheet->setCellValue('B1', ':');
                $sheet->setCellValue('B2', ':');
                $sheet->setCellValue('B3', ':');
                $sheet->mergeCells('C1:D1');
                $sheet->mergeCells('C2:D2');
                $sheet->mergeCells('C3:D3');
                // $sheet->mergeCells('S5:K1');
                // $sheet->mergeCells('J1:K1');
                // $sheet->mergeCells('J2:K2');
                // $sheet->mergeCells('J3:K3');
                // $sheet->mergeCells('M1:O1');
                // $sheet->mergeCells('M2:O2');
                // $sheet->mergeCells('M3:O3');
                $sheet->setCellValue('C1', '(' . $this->dipa->unit->code . ') ' . $this->dipa->unit->name);

                // dd($this->dipa->timeline);
                if ($this->dipa->timeline->category == 'creat') {
                    $ket = "Usulan Definitif";
                } else  if ($this->dipa->timeline->category == 'pra-creat') {
                    $ket = "Usulan Indikatif";
                } else  if ($this->dipa->timeline->category == 'revison') {
                    $ket = "Revisi ke - " . $this->dipa->revision;
                } else {
                    $ket = ' - ';
                }
                $sheet->setCellValue('C2', $ket);
                $sheet->setCellValue('C3', $this->dipa->user?->name);
                $sheet->setCellValue('V1', substr($this->dipa->created_at, 0, 10));
                $sheet->setCellValue('V2', $this->pagu->nominal);
                $sheet->setCellValue('V3', $this->dipa->total);
                // dd($this->dipa->unit);


                // $sheet->setCellValue('A' . $i, 'MISI');
                // $sheet->setCellValue('B' . $i, 'SASARAN PROGRAM');
                // $sheet->setCellValue('C' . $i, 'SASARAN PROGRAM');
                // $sheet->setCellValue('D' . $i, 'SASARAN');
                // $sheet->setCellValue('E' . $i, 'INDIKATOR');
                $sheet->setCellValue('A' . $i, "KOMPONEN");
                $sheet->setCellValue('A' . $i + 1, "KODE");
                $sheet->setCellValue('C' . $i + 1, "DESKRIPSI");
                // $sheet->setCellValue('D' . $i, "AKUN");
                // $sheet->setCellValue('D' . $i + 1, "KODE");
                // $sheet->setCellValue('E' . $i + 1, "DESKRIPSI");
                // $sheet->setCellValue('F' . $i, "KEGIATAN");
                $sheet->setCellValue('D' . $i, "VOLUME");
                $sheet->setCellValue('E' . $i, "SATUAN");
                $sheet->setCellValue('F' . $i, "HARGA");
                $sheet->setCellValue('G' . $i, "TOTAL");
                $sheet->setCellValue('T' . $i, "REALISASI");
                $sheet->setCellValue('U' . $i, "SISA ANGGARAN");
                $bulanSingkat = [
                    1 => 'JAN',
                    2 => 'FEB',
                    3 => 'MAR',
                    4 => 'APR',
                    5 => 'MEI',
                    6 => 'JUN',
                    7 => 'JUL',
                    8 => 'AGU',
                    9 => 'SEP',
                    10 => 'OKT',
                    11 => 'NOV',
                    12 => 'DES',
                ];

                for ($bln = 1; $bln < 13; $bln++) {
                    $curRow = $this->numberToLetter($bln + 7);
                    $sheet->mergeCells($curRow . '5:' . $curRow . '6');

                    $sheet->setCellValue($curRow . $i, $bulanSingkat[$bln]);
                }



                $event->sheet->getDefaultRowDimension()->setRowHeight(-1);

                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ];
                $cellRange = 'A' . $i . ':V' . $i + 1; // All headers
                $event->sheet->getStyle('A5:V6')->applyFromArray($styleArray);
                $styleArray = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                ];
                $i = $j  = $k = $l = $m = $n = $o = 7;

                $s1 = [
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => '03AED2']
                    ]
                ];
                $s2 = [
                    'font' => [
                        'italic' => true,
                    ],
                    'fill' => [

                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => '68D2E8']
                    ]


                ];
                $s3 = [
                    'fill' => [

                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FDDE55']
                    ]
                ];
                foreach ($this->dataBI as $accountGroups) {
                    $rowspanIKU = 0;
                    $rowspanSasaran = 0; // Jumlah row untuk Sasaran
                    $rowspanIndPerkin = 0; // Jumlah row untuk Ind Perkin
                    $rowspanActivity = 0; // Jumlah row untuk Activity
                    $isActivityDisplayed = false;
                    foreach ($accountGroups as $accountCode => $budgetImplementations) {
                        if (!$isActivityDisplayed) {
                            $isActivityDisplayed = true;
                            $sheet->mergeCells('A' . $i . ':B' . $i);
                            $sheet->mergeCells('U' . $i . ':V' . $i);
                            $event->sheet->getDelegate()->getStyle('A' . $i . ':V' . $i)->applyFromArray($s1);
                            $j = $j + 1;
                            $i++;
                        }
                        $j = $i;
                        foreach ($budgetImplementations as $budgetImplementation) {
                            if ($budgetImplementation->accountCode) {
                                $sheet->mergeCells('A' . $j . ':B' . $j);
                                $sheet->mergeCells('U' . $j . ':V' . $j);
                                $event->sheet->getDelegate()->getStyle('A' . $j . ':V' . $j)->applyFromArray($s2);
                                // $sheet->mergeCells('E' . $j . ':J' . $j);
                                $i++;
                                $j++;
                            }
                            $o = $j;
                            foreach ($budgetImplementation->details as $detail) {
                                if ($detail) {
                                    $sheet->mergeCells('A' . $o . ':B' . $o);
                                    $sheet->mergeCells('U' . $o . ':V' . $o);
                                    // $sheet->mergeCells('H' . $o . ':I' . $o);
                                    // $event->sheet->getDelegate()->getStyle('A' . $o . ':H' . $o)->applyFromArray($s3);

                                    $o++;
                                    $i++;
                                    $j++;
                                }
                            }
                            $j = $j + count($budgetImplementation->details)  - 1;
                        }
                    }
                }

                // foreach ($this->dataBI as $misi) {
                //     foreach ($misi['child_missi'] as $iku) {
                //         foreach ($iku['child_iku'] as $sasaran) {
                //             foreach ($sasaran['child_sasaran'] as $ind_perkin) {
                //                 foreach ($ind_perkin['child_ind_perkin'] as $activity) {
                //                     $j_c = 0;
                //                     foreach ($activity['child_activity'] as $bi) {
                //                         $cd = count($bi['detail']);
                //                         if ($cd > 1) {
                //                             $sheet->mergeCells('D' . $i . ':D' . $i + count($bi['detail']) - 1);
                //                             $sheet->mergeCells('E' . $i . ':E' . $i + count($bi['detail']) - 1);
                //                         }
                //                         $i = $i + count($bi['detail']);
                //                         foreach ($bi['detail'] as $detail) {
                //                             $sheet->mergeCells('H' . $o . ':I' . $o);
                //                             $o++;
                //                         }
                //                     }
                //                     $sheet->mergeCells('A' . $j . ':A' . $i - 1);
                //                     $sheet->mergeCells('B' . $j . ':C' . $i - 1);
                //                     $j = $i;
                //                 }
                //             }
                //         }
                //     }
                // }

                $n = $this->total_row;
                $styleArray = [
                    'alignment' => [
                        'wrapText' => true,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                ];
                $cellRange = 'A' . 7 . ':V' . $n - 1; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                $centerStyle = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                // $event->sheet->getDelegate()->getStyle('G' . 5 . ':I' . $n - 1)->applyFromArray($centerStyle);
                $event->sheet->getDelegate()->getStyle('A' . 7 . ':A' . $this->total_row)->applyFromArray($centerStyle);
                $event->sheet->getDelegate()->getStyle('D' . 7 . ':E' . $this->total_row)->applyFromArray($centerStyle);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $event->sheet->autoSize();
                $cellRange = 'A5:V' . $n - 1; // All data rows
                $formatRp = '_-Rp* #.##0_-;-Rp* #.##0_-;_-Rp* "-"_-;_-@_-';
                $formatNumber = '#,##0_-';
                $event->sheet->getDelegate()->getStyle('F7:V' . $n - 1)->getNumberFormat()->setFormatCode($formatNumber);
                $event->sheet->getDelegate()->getStyle('U2:V3')->getNumberFormat()->setFormatCode($formatNumber);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                // $mergedCells = $sheet->getMergeCells();
                // foreach ($mergedCells as $mergedCell) {
                //     $cellTextLength = 0;
                //     $cellRange = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::rangeBoundaries($mergedCell);
                //     $cellColumn = $cellRange[0][0];
                //     if ($cellColumn == 2) {
                //         $cellColumn = 3;
                //     }
                //     $cellRow = $cellRange[0][1];
                //     $cleanedString = preg_replace("/[^0-9:]/", "", $mergedCell); // Menghapus karakter selain huruf besar, angka, dan ':'
                //     $explodedArray = explode(":", $cleanedString);
                //     if ($explodedArray[0] > 5) {
                //         // dd('s');
                //         // if ($mergedCell == 'D11:D14') {
                //         // if ($cellColumn == 1 && $cellRow = 15) {
                //         $cellValue = $sheet->getCell($this->numberToLetter($cellColumn) . $cellRow)->getValue();
                //         $cellTextLength = strlen($cellValue);
                //         $estimatedRowHeight = ceil($cellTextLength / $w[$cellColumn - 1]);
                //         $totalHeight = 0;
                //         for ($row = $cellRange[0][1]; $row <= $cellRange[1][1]; $row++) {
                //             // dd($sheet->getRowDimension($row)->getHighestRow());
                //             $totalHeight++;
                //         }
                //         // dd($cellRange, $cellValue, $cellTextLength, $w[$cellColumn - 1], 'est = ' . $estimatedRowHeight . '   |  curent = ' . $totalHeight);
                //         if ($estimatedRowHeight >  $totalHeight) {
                //             $sheet->getRowDimension($cellRange[1][1])->setRowHeight(($estimatedRowHeight - $totalHeight + 1)  * 15);    // $event->sheet->getDelegate()->getRowDimension(16)->setRowHeight(-1); // Set auto height
                //         }
                //     }
                // }
            },
        ];
    }
    function numberToLetter($number)
    {
        $base = ord('a') - 1; // Mendapatkan nilai ASCII untuk huruf 'a' minus 1
        $result = ''; // Variabel untuk menyimpan hasil konversi

        while ($number > 0) {
            $remainder = $number % 26; // Sisa bagi dengan 26
            if ($remainder == 0) {
                $remainder = 26; // Jika sisa bagi adalah 0, ubah menjadi 26
            }
            $char = chr($base + $remainder); // Mendapatkan karakter huruf dari nilai ASCII
            $result = $char . $result; // Tambahkan huruf ke hasil konversi
            $number = ($number - $remainder) / 26; // Hitung nilai untuk iterasi berikutnya
        }

        return strtoupper($result);
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
