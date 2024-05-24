<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\BudgetImplementation;
use App\Models\BudgetImplementationDetail;
use App\Models\Dipa;
use App\Models\RenstraMission;
use App\Supports\Disk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

use Fpdf\Fpdf;
use Illuminate\Support\Facades\Storage;

use App\Exports\DipaExport;
use App\Exports\DipaByBIExport;
use App\Exports\DipaMappingExport;
use App\Models\PaguUnit;

class PDFController extends Controller
{
    public function cetak(Dipa $dipa)
    {
        // $dataBI = RenstraMission::getWithDipa($dipa->id);
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $paguUnit = PaguUnit::unityear($dipa->year, $dipa->work_unit_id)->first();
        $filename = "Dipa-{$dipa->year}-Revisi-{$dipa->revision}-{$timestamp}.xlsx";
        $groupedBI = BudgetImplementation::getGroupedDataWithTotals($dipa->id);
        return Excel::download(new DipaByBIExport($groupedBI, $dipa,   $paguUnit), $filename);
    }

    public function cetak_mapping(Dipa $dipa)
    {
        $dataBI = RenstraMission::getWithDipa($dipa->id);
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $paguUnit = PaguUnit::unityear($dipa->year, $dipa->work_unit_id)->first();
        $filename = "Dipa-Mapping-{$dipa->year}-Revisi-{$dipa->revision}-{$timestamp}.xlsx";
        return Excel::download(new DipaMappingExport($dataBI, $dipa,  $paguUnit), $filename);
    }
    public function dipa(Dipa $dipa)
    {
        $groupedBI = BudgetImplementation::getGroupedDataWithTotalsRpd($dipa->id, true);
        $pdf = new Fpdf('L', 'mm', 'A4');
        $totalSum = BudgetImplementationDetail::CountTotal($dipa->id);
        // $pdf->SetOrientation('L');
        $pdf->AddPage();
        $pdf->SetFont('Arial', null, 7);
        // $pdf->Cell($tab, 10, 'Hello World!');
        $cel_w = $cel_w2 = [25, 25, 25, 25, 15, 30, 10, 15, 30, 30, 17, 25];
        $cel_w2 = [15, 30, 10, 15, 30, 30, 17, 25];
        $th = 9;
        $tr = 4;
        $this->informasiDipa($pdf, $dipa, $totalSum, $tr);
        $this->headTableDipa($pdf, $cel_w, $th,);

        foreach ($groupedBI as $activityCode => $accountGroups) {
            $isActivityDisplayed = false;
            $x1 = $pdf->GetX();
            $y1 = $pdf->GetY();
            $totalRows = 0;
            // $max()
            $tmp_y = [];
            foreach ($accountGroups as $accountCode => $budgetImplementations) {
                foreach ($budgetImplementations as $budgetImplementation) {
                    if ($budgetImplementation->accountCode) {
                        $totalRows++;
                    }
                    foreach ($budgetImplementation->details as $detail) {
                        if ($detail) {
                            $totalRows++;
                        }
                    }
                }
            }

            foreach ($accountGroups as $accountCode => $budgetImplementations) {

                if (!$isActivityDisplayed) {
                    $isActivityDisplayed = true;
                    $Indikator = $budgetImplementations->first()->activity->performanceIndicator;
                    $misi = $Indikator?->programTarget?->iku?->mission?->description;
                    $catatan = '';
                    $i_note = 1;
                    foreach ($budgetImplementations->first()->activity->activityNote as $note) {
                        $catatan .=  $i_note . '. ' .  $note->description . "\r\n";
                        //  {!! $i_note != 1 ? '<br>' : '' !!}
                        //  {{ $i_note }}. {{ $note->description }}
                        $i_note++;
                    }


                    $res =  $this->statusRow($pdf, $cel_w2, $tr, [
                        $budgetImplementations->first()->activity->code,
                        $budgetImplementations->first()->activity->name,
                        '', '', '',
                        number_format($budgetImplementations->first()->activity_total_sum, 0, ',', '.'),
                    ], null, 110);
                    $tmp_y[] = $res['max_h'];
                }

                // $pdf->SetY($res[''])
                foreach ($budgetImplementations as $budgetImplementation) {
                    if ($budgetImplementation->accountCode) {
                        $pdf->setY($res['max_h']);
                        $res =  $this->statusRow($pdf, $cel_w2, $tr, [
                            $budgetImplementation->accountCode->code,
                            $budgetImplementation->accountCode->name,
                            '', '', '',
                            number_format($budgetImplementations->first()->account_total_sum, 0, ',', '.'),
                        ], null, 110);
                        $tmp_y[] = $res['max_h'];
                    }

                    foreach ($budgetImplementation->details as $detail) {
                        if ($detail) {
                            $pdf->setY($res['max_h']);
                            $res =  $this->statusRow($pdf, $cel_w2, $tr, [
                                '',
                                $detail->name,
                                $detail->volume, $detail->expenditureUnit->code,  number_format($detail->price, 0, ',', '.'),
                                number_format($detail->total, 0, ',', '.'),
                            ], null, 110);
                        }
                    }
                }
                // $output =  $pdf->Output('S');
                // return response()->make($output, 200, [
                //     'Content-Type' => 'application/pdf',
                //     'Content-Disposition' => 'inline; filename="merged.pdf"',
                // ]);
            }

            // if (!$isActivityDisplayed) {
            //     $isActivityDisplayed = true;
            $ind_max1 =  $this->statusRow($pdf, $cel_w, $tr, [
                $misi,
                $Indikator?->programTarget?->iku?->description,
                $Indikator?->programTarget?->name,
                $Indikator?->name,
            ], $y1, $x1, $res['max_h']);

            $ind_max2 =  $this->statusRow($pdf, [17, 25], $tr, [
                $budgetImplementations->first()->activity->activityRecap?->attachment_path ? 'ada' : 'tidak ada',
                $catatan
            ], $y1,  240, [$res['max_h'], $ind_max1['max_h']]);
            $ind_max = max($ind_max2['max_h'], $ind_max1['max_h']);
            // $catatan

            // dd($res['max_h']);
            if ($res['max_h'] < $ind_max) {
                $pdf->SetXY(110, $res['max_h']);
                $pdf->setFillColor(205, 209, 209);
                $pdf->cell(130, $ind_max - $res['max_h'], '', 1, 1, 'R', true);
                // $pdf->SetXY(0, $res['max_h']);
            } else {
                $pdf->SetXY(10, $ind_max);
            }
            // }
            // $output =  $pdf->Output('S');
            // return response()->make($output, 200, [
            //     'Content-Type' => 'application/pdf',
            //     'Content-Disposition' => 'inline; filename="merged.pdf"',
            // ]);
            // die();
            // $pdf->AddPage();
        }
        $output =  $pdf->Output('S');

        return response()->make($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="merged.pdf"',
        ]);


        // return response()->make($output, 200, [
        //     'Content-Type' => 'application/pdf',
        //     'Content-Disposition' => 'attachment; filename="merged.pdf"',
        // ]);
        // return   $pdf->Output();
    }

    function headTableDipa($pdf, $cel_w, $th)
    {
        $pdf->SetFont('Arial', 'B', 7);

        $pdf->Cell($cel_w[0], $th, 'MISI (RENSTRA)', 1, 0, 'C');
        $pdf->Cell($cel_w[1], $th, 'SASARAN PROGRAM (RENSTRA)', 1, 0, 'C');
        $pdf->Cell($cel_w[2], $th, 'Sasaran (PERKIN)', 1, 0, 'C');
        $pdf->Cell($cel_w[3], $th, 'Indikator (PERKIN)', 1, 0, 'C');
        $pdf->Cell($cel_w[4], $th, 'Kode', 1, 0, 'C');
        $pdf->Cell($cel_w[5], $th, 'Sub Komponen', 1, 0, 'C');
        $pdf->Cell($cel_w[6], $th, 'Vol', 1, 0, 'C');
        $pdf->Cell($cel_w[7], $th, 'Unit', 1, 0, 'C');
        $pdf->Cell($cel_w[8], $th, 'Harga', 1, 0, 'C');
        $pdf->Cell($cel_w[9], $th, 'Jumlah', 1, 0, 'C');
        $pdf->Cell($cel_w[10], $th, 'Data Dukung', 1, 0, 'C');
        $pdf->Cell($cel_w[11], $th, 'Catatan', 1, 1, 'C');
        $pdf->SetFont('Arial', null, 7);
    }

    function informasiDipa($pdf,  $dipa, $totalSum, $h = 4)
    {
        $tab = 90;
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(25, $h, 'Unit Kerja', 0);
        $pdf->Cell(3, $h, ':', 0);
        $pdf->Cell(100, $h, $dipa->unit->name, 0, 0);
        $pdf->Cell($tab, $h, '', 0, 0);

        $pdf->Cell(25, $h, 'Tanggal Entri', 0);
        $pdf->Cell(3, $h, ':', 0);
        $pdf->Cell(0, $h, $dipa->created_at, 0, 1); // Baris baru

        $pdf->Cell(25, $h, 'Petugas Entri', 0);
        $pdf->Cell(3, $h, ':', 0);
        $pdf->Cell(100, $h, $dipa->user ? $dipa->user->name : 'N/A', 0, 0); // Baris baru
        $pdf->Cell($tab, $h, '', 0, 0);
        $pdf->Cell(25, $h, 'Pagu Unit Kerja', 0);
        $pdf->Cell(3, $h, ':', 0);
        $pdf->Cell(0, $h, 'Rp ' . number_format($dipa->unit->unitBudgets[0]->pagu ?? 0, 0, ',', '.'), 0, 1); // Baris baru

        $pdf->Cell(25, $h, 'Revisi ke', 0);
        $pdf->Cell(3, $h, ':', 0);
        $pdf->Cell(100, $h, $dipa->revision, 0, 0); // Baris baru
        $pdf->Cell($tab, $h, '', 0, 0);



        $pdf->Cell(25, $h, 'Total Usulan', 0);
        $pdf->Cell(3, $h, ':', 0);
        $pdf->Cell(0, $h, 'Rp ' . number_format($totalSum, 0, ',', '.'), 0, 1); // Baris baru
    }
    function statusRow($pdf, $width, $h, $data, $y_origin = null, $x_origin = null, $max_h = null)
    {
        // dd($x_origin);
        if ($y_origin == null)
            $y_origin = $pdf->GetY();
        if ($x_origin == null)
            $x_origin = $pdf->GetX();
        $counter_w = 0;
        if ($max_h == null) {
            $max_h =  $y_origin;
        } else {
            if (is_array($max_h) && count($max_h) > 0) {
                $max_h = max($max_h);
            } else {
                $max_h = $max_h;
            }
        }
        foreach ($data as $key => $d) {
            $pdf->SetXY($x_origin + $counter_w, $y_origin);
            $pdf->MultiCell($width[$key], $h,   $d, 0, 0);
            $counter_w += $width[$key];
            $max_h = max($max_h, $pdf->GetY());
        }
        $max_h = $max_h - $y_origin;
        $counter_w = 0;
        foreach ($data as $key => $d) {
            $pdf->SetXY($x_origin + $counter_w, $y_origin);
            $pdf->Rect($x_origin + $counter_w, $y_origin, $width[$key], $max_h);
            $counter_w += $width[$key];
        }
        return ['max_h' => $max_h + $y_origin];
    }
    function SetDash($black = null, $white = null)
    {
        if ($black !== null)
            $s = sprintf('[%.3F %.3F] 0 d', $black * $this->k, $white * $this->k);
        else
            $s = '[] 0 d';
        $this->_out($s);
    }
    // function NbLines($w, $txt)
    // {
    // 	//Computes the number of lines a MultiCell of width w will take
    // 	$cw = &$pdf->CurrentFont['cw'];
    // 	if ($w == 0)
    // 		$w = $pdf->w - $pdf->rMargin - $pdf->x;
    // 	$wmax = ($w - 2 * $pdf->cMargin) * 1000 / $this->FontSize;
    // 	$s = str_replace("\r", '', $txt);
    // 	$nb = strlen($s);
    // 	if ($nb > 0 and $s[$nb - 1] == "\n")
    // 		$nb--;
    // 	$sep = -1;
    // 	$i = 0;
    // 	$j = 0;
    // 	$l = 0;
    // 	$nl = 1;
    // 	while ($i < $nb) {
    // 		$c = $s[$i];
    // 		if ($c == "\n") {
    // 			$i++;
    // 			$sep = -1;
    // 			$j = $i;
    // 			$l = 0;
    // 			$nl++;
    // 			continue;
    // 		}
    // 		if ($c == ' ')
    // 			$sep = $i;
    // 		$l += $cw[$c];
    // 		if ($l > $wmax) {
    // 			if ($sep == -1) {
    // 				if ($i == $j)
    // 					$i++;
    // 			} else
    // 				$i = $sep + 1;
    // 			$sep = -1;
    // 			$j = $i;
    // 			$l = 0;
    // 			$nl++;
    // 		} else
    // 			$i++;
    // 	}
    // 	return $nl;
    // }
}
