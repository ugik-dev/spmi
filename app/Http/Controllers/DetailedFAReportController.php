<?php

namespace App\Http\Controllers;

use App\Exports\DipaReportFa;
use App\Models\BudgetImplementation;
use App\Models\Dipa;
use App\Models\PaguUnit;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DetailedFAReportController extends Controller
{
    public function index()
    {
        $title = 'Verifikasi Pembayaran';
        $dipas = Dipa::accessibility()->where('status', '=', 'release')->get();
        return view('app.detailed-FA-report', compact('title', 'dipas'));
    }

    public function excel(Dipa $dipa)
    {
        // $dataBI = RenstraMission::getWithDipa($dipa->id);
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $paguUnit = PaguUnit::unityear($dipa->year, $dipa->work_unit_id)->first();
        $filename = "FA-DETAIL-Dipa-{$dipa->year}-Revisi-{$dipa->revision}-{$timestamp}.xlsx";
        $groupedBI = BudgetImplementation::getGroupedDataWithTotals($dipa->id);
        // dd($groupedBI);
        return Excel::download(new DipaReportFa($groupedBI, $dipa,   $paguUnit), $filename);
    }
}
