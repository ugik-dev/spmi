<?php

namespace App\Http\Controllers;

use App\Enums\Month;
use App\Models\AccountCode;
use App\Models\BudgetImplementation;
use App\Models\BudgetImplementationDetail;
use App\Models\Dipa;
use App\Models\DipaLog;
use App\Models\ExpenditureUnit;
use App\Models\PerformanceIndicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class DipaController extends Controller
{
    //

    public function approval()
    {
        $title = 'Daftar DIPA';
        $dipas = Dipa::accessibility()->get();
        return view('app.budget-implementation-approval', compact('title', 'dipas',));
    }
    public function review(Dipa $dipa)
    {
        $dipa->bi;
        $dipa->unit;
        // dd($dipa);
        $groupedBI = BudgetImplementation::getGroupedDataWithTotalsRpd($dipa->id, true);
        $title = 'Daftar DIPA';
        $totalSum = BudgetImplementationDetail::CountTotal($dipa->id);
        $accountCodes = AccountCode::all();
        $indikatorPerkin = PerformanceIndicator::all();
        $expenditureUnits = ExpenditureUnit::all();
        $months = Month::cases();
        return view('app.budget-implementation-review', compact(
            'title',
            'dipa',
            'months',
            'groupedBI',
            'accountCodes',
            'expenditureUnits',
            'totalSum',
            'indikatorPerkin',
            // 'unitBudget',
        ));
    }

    public function pdf(Dipa $dipa)
    {
        $dompdf = new PDF();
        $dipa->bi;
        $dipa->unit;
        $dipa->user;
        // dd($dipa);
        $groupedBI = BudgetImplementation::getGroupedDataWithTotalsRpd($dipa->id, true);
        $title = 'Daftar DIPA';
        $totalSum = BudgetImplementationDetail::CountTotal($dipa->id);
        // $accountCodes = AccountCode::all();
        // $indikatorPerkin = PerformanceIndicator::all();
        // $expenditureUnits = ExpenditureUnit::all();
        // $months = Month::cases();
        // return View('app.budget-implementation-pdf', compact('dipa', 'totalSum', 'groupedBI'));
        $pdf = PDF::loadView('app.budget-implementation-pdf', compact('dipa', 'totalSum', 'groupedBI'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('invoice.pdf');
        // return view('app.budget-implementation-pdf', compact(
        //     'title',
        //     'dipa',
        //     'months',
        //     'groupedBI',
        //     'accountCodes',
        //     'expenditureUnits',
        //     'totalSum',
        //     'indikatorPerkin',
        //     // 'unitBudget',
        // ));
    }

    public function approval_kp(Request $request, Dipa $dipa)
    {
        try {
            if (
                in_array($dipa->status, ['wait-kp', 'reject-kp']) &&
                $dipa->work_unit_id == Auth::user()->employee?->work_unit_id &&
                Auth::user()->hasRole(['KEPALA UNIT KERJA'])
            ) {
            } else {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }
            $log = new DipaLog();
            if ($request->res == 'Y') {
                $dipa->status = 'wait-ppk';
                $log->label = "success";
                $log->description = "Melakukan Approv";
            } else {
                $dipa->status = 'reject-kp';
                $log->label = "danger";
                if (!empty($request->description)) $log->description = "Melakukan Penolakan dengan alasan " . $request->description;
                else $log->description = "Melakukan Penolakan";
            }
            $dipa->save();

            $log->dipa_id = $dipa->id;
            $log->user_id = Auth::user()->id;
            $log->save();

            return response()->json(['error' => false,  'message' => $request->res], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
    public function log(Request $request, Dipa $dipa)
    {
        try {
            $log = DipaLog::with('user')->where('dipa_id', '=', $dipa->id)->get();
            return response()->json(['error' => false,  'message' => $request->res, 'data' => $log], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
    public function approval_ppk(Request $request, Dipa $dipa)
    {
        try {
            if (
                in_array($dipa->status, ['wait-ppk', 'reject-ppk']) &&
                // $dipa->work_unit_id == Auth::user()->employee?->work_unit_id &&
                Auth::user()->hasRole(['PPK'])
            ) {
            } else {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }
            $log = new DipaLog();
            if ($request->res == 'Y') {
                $dipa->status = 'wait-spi';
                $log->label = "success";
                $log->description = "Melakukan Approv";
            } else {
                $dipa->status = 'reject-ppk';
                $log->label = "danger";
                if (!empty($request->description)) $log->description = "Melakukan Penolakan dengan alasan " . $request->description;
                else $log->description = "Melakukan Penolakan";
            }
            $dipa->save();

            $log->dipa_id = $dipa->id;
            $log->user_id = Auth::user()->id;
            $log->save();

            return response()->json(['error' => false,  'message' => $request->res], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function approval_spi(Request $request, Dipa $dipa)
    {
        try {
            if (
                in_array($dipa->status, ['wait-spi', 'reject-spi']) &&
                // $dipa->work_unit_id == Auth::user()->employee?->work_unit_id &&
                Auth::user()->hasRole(['SPI'])
            ) {
            } else {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }
            $log = new DipaLog();
            if ($request->res == 'Y') {
                $dipa->status = 'wait-perencanaan';
                $log->label = "success";
                $log->description = "Melakukan Approv";
            } else {
                $dipa->status = 'reject-spi';
                $log->label = "danger";
                if (!empty($request->description)) $log->description = "Melakukan Penolakan dengan alasan " . $request->description;
                else $log->description = "Melakukan Penolakan";
            }
            $dipa->save();

            $log->dipa_id = $dipa->id;
            $log->user_id = Auth::user()->id;
            $log->save();

            return response()->json(['error' => false,  'message' => $request->res], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function approval_perencanaan(Request $request, Dipa $dipa)
    {
        try {
            if (
                in_array($dipa->status, ['wait-perencanaan', 'reject-perencanaan']) &&
                // $dipa->work_unit_id == Auth::user()->employee?->work_unit_id &&
                Auth::user()->hasRole(['SPI'])
            ) {
            } else {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }
            $log = new DipaLog();
            if ($request->res == 'Y') {
                $dipa->status = 'accept';
                $log->label = "success";
                $log->description = "Melakukan Approv";
            } else {
                $dipa->status = 'reject-perencanaan';
                $log->label = "danger";
                if (!empty($request->description)) $log->description = "Melakukan Penolakan dengan alasan " . $request->description;
                else $log->description = "Melakukan Penolakan";
            }
            $dipa->save();

            $log->dipa_id = $dipa->id;
            $log->user_id = Auth::user()->id;
            $log->save();

            return response()->json(['error' => false,  'message' => $request->res], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}
