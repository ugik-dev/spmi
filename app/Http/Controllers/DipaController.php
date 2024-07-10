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
use App\Mail\MailPermohonanDipa;
use Illuminate\Support\Facades\Mail;
use App\Models\Activity;
use App\Models\PaguUnit;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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

    public function rekap()
    {
        $title = 'Rekap DIPA';
        $dipas = Dipa::accessibility()->where('status', '=', 'release')->get();
        return view('app.budget-implementation-rekap', compact('title', 'dipas',));
    }
    public function ajukan(Dipa $dipa)
    {
        try {
            $totalSum = BudgetImplementationDetail::CountTotal($dipa->id);
            // $act = Activity::akumulasiRPD();
            $act = Activity::where('dipa_id', $dipa->id)->get();
            $rpd = 0;
            foreach ($act as $ac) {
                if (!empty($ac->activityRecap->attachment_path)) {
                    // $filePath = 'app/activity/attachments-recap/' . $ac->activityRecap->attachment_path;
                    // dd($filePath);
                    // dd(Storage::exists($filePath));
                    // if (!Storage::exists($filePath)) {
                    //     return response()->json(['message' => 'Berkas ' . $ac->code . ' Upload ada yang rusak, harap cek !!'], 500);
                    // }
                } else {
                    return response()->json(['message' => 'Berkas Upload kurang !!'], 500);
                }
                // $fileMimeType = mime_content_type($filePath);
                // dd($ac->activityRecap);
                if ($ac->activityRecap) {
                }
                $rpd += $ac->withdrawalPlans->sum('amount_withdrawn');
                // echo $ac->withdrawalPlans->sum('amount_withdrawn') . '<br>';
            }
            $paguUnit = PaguUnit::unityear($dipa->year, $dipa->work_unit_id)->first();
            if ($paguUnit->nominal != $totalSum) {
                return response()->json(['message' => 'Total Usulan tidak sama dengan Pagu yaitu Rp ' . number_format($paguUnit->nominal) . ' !!'], 500);
            } else
            if ($rpd != $totalSum) {
                return response()->json(['message' => 'Total RPD tidak sama dengan Usulan DIPA !!'], 500);
            } else
            if (!in_array($dipa->status, ['draft', 'reject-ppk', 'reject-spi', 'reject-ppk'])) {
                return response()->json(['message' => 'Bukan waktu untuk mengajukan !!'], 500);
            }
            if ($dipa->user_id != Auth::user()->id) {
                return response()->json(['message' => 'Kamu tidak berhak !!'], 500);
            }
            if (empty($dipa->unit->kepalaUnit->email)) {
                return response()->json(['message' => 'Tidak dapat mengirimkan email ke Kepala Unit'], 500);
            };

            Mail::to($dipa->unit->kepalaUnit->email)->send(new MailPermohonanDipa($dipa));
            $dipa->total = $totalSum;
            $dipa->status = 'wait-kp';
            $dipa->save();

            DipaLog::create(['dipa_id' => $dipa->id, 'user_id' => Auth::user()->id, 'description' => "Mengajukan permohonan approval"]);
            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            Log::error('Error in store function: ' . $e->getMessage());

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function review(Dipa $dipa)
    {
        $dipa->bi;
        $dipa->unit;
        $groupedBI = BudgetImplementation::getGroupedDataWithTotalsRpd($dipa->id, true);
        $title = 'Daftar DIPA';
        $unitBudget = PaguUnit::unityear($dipa->year, $dipa->work_unit_id)->first();
        $totalSum = BudgetImplementationDetail::CountTotal($dipa->id);
        $accountCodes = AccountCode::all();
        $indikatorPerkin = PerformanceIndicator::all();
        $expenditureUnits = ExpenditureUnit::all();
        $btnExport = [
            'pdf' => true,
            'exl_simple' => true,
            'exl_mapping' => true,
        ];
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
            'btnExport',
            'unitBudget'
        ));
    }
    public function review_rekap(Dipa $dipa)
    {
        $dipa->bi;
        $dipa->unit;
        $groupedBI = BudgetImplementation::getGroupedDataWithTotalsRpd($dipa->id, true);
        $title = 'Daftar DIPA';
        $totalSum = BudgetImplementationDetail::CountTotal($dipa->id);
        $unitBudget = PaguUnit::unityear($dipa->year, $dipa->work_unit_id)->first();

        $accountCodes = AccountCode::all();
        $btnExport = [
            'pdf' => true,
            'exl_simple' => true,
            'exl_mapping' => true,
        ];
        $indikatorPerkin = PerformanceIndicator::all();
        $expenditureUnits = ExpenditureUnit::all();
        $months = Month::cases();
        return view('app.budget-implementation-review-rekap', compact(
            'title',
            'dipa',
            'months',
            'groupedBI',
            'accountCodes',
            'expenditureUnits',
            'totalSum',
            'indikatorPerkin',
            'btnExport',
            'unitBudget'
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
                $dipa->unit->kepala == Auth::user()->id
                // $dipa->work_unit_id == Auth::user()->employee?->work_unit_id &&
                // Auth::user()->hasRole(['KEPALA UNIT KERJA'])
            ) {
            } else {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }


            $log = new DipaLog();
            if ($request->res == 'Y') {



                if ($dipa->timeline->metode == 'ppk') {
                    if (empty($dipa->unit->ppkUnit->email)) {
                        return response()->json(['message' => 'Tidak dapat mengirimkan email ke PPK'], 500);
                    };
                    Mail::to($dipa->unit->ppkUnit->email)->send(new MailPermohonanDipa($dipa));
                    $dipa->status = 'wait-ppk';
                } else if ($dipa->timeline->metode == 'kpa') {
                    $rektor = User::whereHas('roles', function ($q) {
                        $q->where('name', 'KPA (REKTOR)');
                    })->first();
                    if (empty($rektor->email)) {
                        return response()->json(['message' => 'Tidak dapat mengirimkan email ke Rektor'], 500);
                    };
                    Mail::to($rektor->email)->send(new MailPermohonanDipa($dipa));
                    $dipa->status = 'wait-kpa';
                }

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

    public function approval_kpa(Request $request, Dipa $dipa)
    {
        try {
            if (
                in_array($dipa->status, ['wait-kpa', 'reject-kpa']) &&
                Auth::user()->hasRole(['KPA (REKTOR)'])
            ) {
            } else {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }
            $log = new DipaLog();
            if ($request->res == 'Y') {

                // if (in_array($dipa->work_unit_id, ['16', '22'])) {
                //     if ($dipa->timeline->metode == 'ppk')
                //         $dipa->status = 'wait-ppk';
                //     else
                //         $dipa->status = 'wait-spi';
                // } else {
                if ($dipa->timeline->metode == 'ppk')
                    $dipa->status = 'wait-ppk';
                else if ($dipa->timeline->metode == 'kpa')
                    $dipa->status = 'wait-spi';
                // }

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
                Auth::user()->hasRole(['SUPER ADMIN PERENCANAAN'])
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

    public function approval_release(Request $request, Dipa $dipa)
    {
        try {
            if (
                in_array($dipa->status, ['accept']) &&
                // $dipa->work_unit_id == Auth::user()->employee?->work_unit_id &&
                Auth::user()->hasRole(['SUPER ADMIN PERENCANAAN'])
            ) {
            } else {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }
            $log = new DipaLog();
            if ($request->res == 'Y') {
                $dipa->status = 'release';
                $log->label = "success";
                $log->description = "Terbit POK";
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
