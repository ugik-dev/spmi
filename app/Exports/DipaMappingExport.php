<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class DipaMappingExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, WithEvents
{
    protected $dataBI;
    protected $dipa;
    protected $pagu;

    public function __construct($dataBI, $dipa, $pagu)
    {
        $this->dataBI = $dataBI;
        $this->dipa = $dipa;
        $this->pagu = $pagu;
    }
    public function startCell(): string
    {
        return 'A6';
    }
    public function collection()
    {

        $dataBI = $this->dataBI;

        $exportData = collect();
        // $sheet = Excel::sheet();
        // $i = 4;
        foreach ($dataBI as $misi) {
            $rowspanMisi = count($misi['child_missi']);
            $rowspanIKU = 0; // Jumlah row untuk SASARAN PROGRAM
            $rowspanSasaran = 0; // Jumlah row untuk Sasaran
            $rowspanIndPerkin = 0; // Jumlah row untuk Ind Perkin
            $rowspanActivity = 0; // Jumlah row untuk Activity
            foreach ($misi['child_missi'] as $iku) {
                $rowspanIKU += count($iku['child_iku']);
                foreach ($iku['child_iku'] as $sasaran) {
                    $rowspanSasaran += count($sasaran['child_sasaran']);
                    foreach ($sasaran['child_sasaran'] as $ind_perkin) {
                        $rowspanIndPerkin += count($ind_perkin['child_ind_perkin']);
                        foreach ($ind_perkin['child_ind_perkin'] as $activity) {
                            $rowspanActivity += count($activity['child_activity']);
                            foreach ($activity['child_activity'] as $bi) {
                                foreach ($bi['detail'] as $detail) {
                                    $dataPush = [
                                        $misi['parent']['description'],
                                        '',
                                        $iku['parent']['description'],
                                        $sasaran['parent']['name'],
                                        $ind_perkin['parent']['name'],
                                        $activity['parent']['code'],
                                        $activity['parent']['name'],
                                        $bi['bi']->accountCode->code,
                                        $bi['bi']->accountCode->name,
                                        $detail['name'],
                                        $detail['volume'],
                                        '',
                                        $detail->expenditureUnit->code,
                                        $detail['price'],
                                        $detail['total'],
                                    ];
                                    // dd
                                    $exportData->push($dataPush);
                                }
                            }
                        }
                    }
                }
            }
            // // Merge cells untuk kolom SASARAN PROGRAM
            // $sheet->mergeCells("C{$i}:C" . ($i + $rowspanIKU - 1));
            // // Merge cells untuk kolom Sasaran
            // $sheet->mergeCells("D{$i}:D" . ($i + $rowspanSasaran - 1));
            // // Merge cells untuk kolom Ind Perkin
            // $sheet->mergeCells("E{$i}:E" . ($i + $rowspanIndPerkin - 1));
            // // Merge cells untuk kolom Activity
            // $sheet->mergeCells("F{$i}:F" . ($i + $rowspanActivity - 1));

            // $i += $rowspanMisi;
        }

        return $exportData;
    }


    public function headings(): array
    {
        return [
            'Misi',
            'SASARAN PROGRAM',
            'Sasaran',
            'Indikator',
            'Kode',
            'Deskripsi',
            'Kode',
            'Deskripsi',
            'Kegiatan', // Kosong untuk memberikan ruang
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
                $w = [20, 2, 20, 20, 20, 6, 10, 7.5, 10, 10, 6, 2, 6, 10, 10];
                $sheet->getColumnDimension('A')->setWidth($w[0]);
                $sheet->getColumnDimension('B')->setWidth($w[1]);
                $sheet->getColumnDimension('C')->setWidth($w[2]);
                $sheet->getColumnDimension('D')->setWidth($w[3]);
                $sheet->getColumnDimension('E')->setWidth($w[4]);
                $sheet->getColumnDimension('F')->setWidth($w[5]);
                $sheet->getColumnDimension('G')->setWidth($w[6]);
                $sheet->getColumnDimension('H')->setWidth($w[7]);
                $sheet->getColumnDimension('I')->setWidth($w[8]);
                $sheet->getColumnDimension('J')->setWidth($w[9]);
                $sheet->getColumnDimension('K')->setWidth($w[10]);
                $sheet->getColumnDimension('L')->setWidth($w[11]);
                $sheet->getColumnDimension('M')->setWidth($w[12]);
                $sheet->getColumnDimension('N')->setWidth($w[13]);
                $sheet->getColumnDimension('O')->setWidth($w[14]);

                $i = 5;
                $sheet->mergeCells('A' . $i . ':B' . $i + 1);
                // $sheet->mergeCells('B' . $i . ':B' . $i + 1);
                $sheet->mergeCells('C' . $i . ':C' . $i + 1);
                $sheet->mergeCells('D' . $i . ':D' . $i + 1);
                $sheet->mergeCells('E' . $i . ':E' . $i + 1);
                $sheet->mergeCells('F' . $i . ':G' . $i);
                $sheet->mergeCells('H' . $i . ':I' . $i);
                $sheet->mergeCells('J' . $i . ':J' . $i + 1);
                $sheet->mergeCells('K' . $i . ':L' . $i + 1);
                // $sheet->mergeCells('I' . $i . ':I' . $i + 1);
                // $sheet->mergeCells('L' . $i . ':L' . $i + 1);
                $sheet->mergeCells('M' . $i . ':M' . $i + 1);
                $sheet->mergeCells('N' . $i . ':N' . $i + 1);
                $sheet->mergeCells('O' . $i . ':O' . $i + 1);

                $sheet->setCellValue('A1', 'Unit Kerja');
                $sheet->setCellValue('A2', 'Revisi');
                $sheet->setCellValue('A3', 'Petugas');

                $sheet->setCellValue('J1', 'Tanggal');
                $sheet->setCellValue('J2', 'Pagu Unit Kerja');
                $sheet->setCellValue('J3', 'Total Usulan');
                $sheet->setCellValue('L1', ':');
                $sheet->setCellValue('L2', ':');
                $sheet->setCellValue('L3', ':');
                $sheet->setCellValue('B1', ':');
                $sheet->setCellValue('B2', ':');
                $sheet->setCellValue('B3', ':');
                $sheet->mergeCells('J1:K1');
                $sheet->mergeCells('J2:K2');
                $sheet->mergeCells('J3:K3');
                $sheet->mergeCells('M1:O1');
                $sheet->mergeCells('M2:O2');
                $sheet->mergeCells('M3:O3');
                $sheet->setCellValue('C1', '(' . $this->dipa->unit->code . ') ' . $this->dipa->unit->name);
                $sheet->setCellValue('C2', "ke- " . $this->dipa->revision);
                $sheet->setCellValue('C3', $this->dipa->user?->name);
                $sheet->setCellValue('M1', $this->dipa->created_at);
                $sheet->setCellValue('M2',                 $this->pagu->nominal);

                $sheet->setCellValue('M3', $this->dipa->total);
                // dd($this->dipa->unit);


                $sheet->setCellValue('A' . $i, 'MISI');
                // $sheet->setCellValue('B' . $i, 'SASARAN PROGRAM');
                $sheet->setCellValue('C' . $i, 'SASARAN PROGRAM');
                $sheet->setCellValue('D' . $i, 'SASARAN');
                $sheet->setCellValue('E' . $i, 'INDIKATOR');
                $sheet->setCellValue('F' . $i, "KOMPONEN");
                $sheet->setCellValue('F' . $i + 1, "KODE");
                $sheet->setCellValue('G' . $i + 1, "DESKRIPSI");
                $sheet->setCellValue('H' . $i, "AKUN");
                $sheet->setCellValue('H' . $i + 1, "KODE");
                $sheet->setCellValue('I' . $i + 1, "DESKRIPSI");
                $sheet->setCellValue('J' . $i, "KEGIATAN");
                $sheet->setCellValue('K' . $i, "VOLUME");
                $sheet->setCellValue('M' . $i, "SATUAN");
                $sheet->setCellValue('N' . $i, "HARGA");
                $sheet->setCellValue('O' . $i, "TOTAL");

                $event->sheet->getDefaultRowDimension()->setRowHeight(15);

                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ];
                $cellRange = 'A' . $i . ':O' . $i + 1; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);


                $styleArray = [
                    'alignment' => [
                        // 'wrapText' => true,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                ];
                $i = $j  = $k = $l = $m = $n = $o = 7;
                // dd($this->dataBI);
                foreach ($this->dataBI as $misi) {
                    foreach ($misi['child_missi'] as $iku) {
                        foreach ($iku['child_iku'] as $sasaran) {
                            foreach ($sasaran['child_sasaran'] as $ind_perkin) {
                                foreach ($ind_perkin['child_ind_perkin'] as $activity) {
                                    $j_c = 0;
                                    foreach ($activity['child_activity'] as $bi) {
                                        if (count($bi['detail']) > 1) {
                                            $sheet->mergeCells('H' . $i . ':H' . $i + $bi['bi']['rowspan'] - 1);
                                            $sheet->mergeCells('I' . $i . ':I' . $i + $bi['bi']['rowspan'] - 1);
                                        }
                                        $i = $i + $bi['bi']['rowspan'];
                                        foreach ($bi['detail'] as $detail) {
                                            $sheet->mergeCells('K' . $o . ':L' . $o);
                                            // $sheet->getRowDimension($o)->setRowHeight(15);
                                            $o++;
                                        }
                                    }
                                    $sheet->mergeCells('F' . $j . ':F' . $i - 1);
                                    $sheet->mergeCells('G' . $j . ':G' . $i - 1);
                                    $j = $i;
                                }
                                $sheet->mergeCells('E' . $k . ':E' . $j - 1);
                                $k = $j;
                            }
                            $sheet->mergeCells('D' . $l . ':D' . $k - 1);
                            $l = $k;
                        }
                        $sheet->mergeCells('C' . $m . ':C' . $l - 1);
                        $m = $l;
                    }
                    $sheet->mergeCells('A' . $n . ':B' . $m - 1);
                    $n = $m;
                }

                $styleArray = [
                    'alignment' => [
                        'wrapText' => true,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                ];
                $cellRange = 'A7:O' . $n - 1; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('K5:M' . $n - 1)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $event->sheet->getDelegate()->getStyle('F7:F' . $n - 1)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                $event->sheet->getDelegate()->getStyle('H7:H' . $n - 1)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                // $sheet->setAutoSize(true);
                $event->sheet->autoSize();
                // Mengaplikasikan style border ke seluruh kolom dan baris yang digabungkan
                $cellRange = 'A5:O' . $n - 1; // All data rows
                $formatRp = '_-Rp* #.##0_-;-Rp* #.##0_-;_-Rp* "-"_-;_-@_-';
                $formatNumber = '#,##0_-';
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('N7:O' . $n - 1)->getNumberFormat()->setFormatCode($formatNumber);
                $event->sheet->getDelegate()->getStyle('M2:O3')->getNumberFormat()->setFormatCode($formatNumber);

                $mergedCells = $sheet->getMergeCells();
                foreach ($mergedCells as $mergedCell) {

                    $cellTextLength = 0;
                    $cellRange = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::rangeBoundaries($mergedCell);
                    $cellColumn = $cellRange[0][0];
                    $cellRow = $cellRange[0][1];
                    $cleanedString = preg_replace("/[^0-9:]/", "", $mergedCell); // Menghapus karakter selain huruf besar, angka, dan ':'
                    $explodedArray = explode(":", $cleanedString);
                    if ($explodedArray[0] > 5) {
                        // dd('s');
                        // if ($mergedCell == 'D11:D14') {
                        // if ($cellColumn == 1 && $cellRow = 15) {
                        $cellValue = $sheet->getCell($this->numberToLetter($cellColumn) . $cellRow)->getValue();
                        $cellTextLength = strlen($cellValue);
                        $estimatedRowHeight = ceil($cellTextLength / $w[$cellColumn - 1]);
                        $totalHeight = 0;
                        for ($row = $cellRange[0][1]; $row <= $cellRange[1][1]; $row++) {
                            // dd($sheet->getRowDimension($row)->getHighestRow());
                            $totalHeight++;
                        }
                        // dd($cellRange, $cellValue, $cellTextLength, $w[$cellColumn - 1], 'est = ' . $estimatedRowHeight . '   |  curent = ' . $totalHeight);
                        if ($estimatedRowHeight >  $totalHeight) {
                            $sheet->getRowDimension($cellRange[1][1])->setRowHeight(($estimatedRowHeight - $totalHeight + 1)  * 15);    // $event->sheet->getDelegate()->getRowDimension(16)->setRowHeight(-1); // Set auto height
                        }
                    }
                }
            },
        ];
    }
    function numberToLetter($number)
    {
        $base = ord('a') - 1; // Mendapatkan nilai ASCII untuk huruf 'a' minus 1
        $result = ''; // Variabel untuk menyimpan hasil konversi

        // Konversi angka menjadi huruf sesuai aturan
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
