<?php

namespace App\Http\Controllers;

use App\Models\Dipa;
use App\Models\DipaLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DipaController extends Controller
{
    //

    public function approval()
    {
        $title = 'Daftar DIPA';
        $dipas = Dipa::where('work_unit_id', Auth::user()->employee->work_unit_id)->get();
        return view('app.budget-implementation-approval', compact('title', 'dipas',));
    }

    public function approval_kp(Request $request, Dipa $dipa)
    {
        try {
            // $dipa->load('ppk');

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
                // $dipa->spi_id = Auth::user()->id;
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
}
