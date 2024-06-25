<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkUnit;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;

class WorkUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Unit Kerja';
        $workUnits = WorkUnit::with(['ppkUnit'])->get();
        $ppks = User::whereHas('roles', function ($q) {
            $q->where('name', 'PPK');
        })->get();
        $kepalas = User::whereHas('roles', function ($q) {
            $q->where('name', 'KEPALA UNIT KERJA');
        })->get(); //cari where has role PPK
        return view('app.work-unit', compact('title', 'ppks', 'kepalas', 'workUnits'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'work_unit_name' => 'required|string|max:255', // Validation for names
            'work_unit_code' => 'nullable|string|max:255', // Validation for codes
            'kepala' => 'nullable|integer', // Validation for codes
            'ppk' => 'nullable|integer', // Validation for codes
        ]);

        WorkUnit::create([
            'name' => $request->work_unit_name,
            'code' => $request->work_unit_code,
            'ppk' => $request->ppk,
            'kepala' => $request->kepala,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan unit kerja.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkUnit $workUnit)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Assuming 'name' is a required field
            'code' => 'nullable|string|max:255', // Assuming 'code' is optional
            'kepala' => 'nullable|integer', // Validation for codes
            'ppk' => 'nullable|integer', // Validation for codes
        ]);

        // Update the WorkUnit with validated data
        $workUnit->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('work_unit.index')->with('success', 'Unit Kerja berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkUnit $workUnit)
    {
        $workUnit->delete();

        return redirect()->back()->with('success', 'Unit kerja berhasil dihapus.');
    }

    // fungsi export pdf
    public function downloadWorkUnitPdf()
    {
        $workUnits = WorkUnit::with(['ppkUnit', 'kepalaUnit'])->get();
        
        // Mendapatkan tanggal dan waktu saat ini
        $date = Carbon::now()->format('Y-m-d_H-i-s');

        $pdf = PDF::loadView('components.custom.pdf.downloadWorkUnitPdf', ['workUnits' => $workUnits]);
        return $pdf->download("Unit_Kerja_{$date}.pdf");
    }
}
