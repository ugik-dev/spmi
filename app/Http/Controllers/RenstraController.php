<?php

namespace App\Http\Controllers;

use App\Models\Renstra;
use App\Models\RenstraIndicator;
use App\Models\RenstraMission;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\MissionsExport;
use App\Exports\IkusExport;

class RenstraController extends Controller
{
    public function vision()
    {
        $renstra = Renstra::first();

        return view('app.vision', ['title' => 'VISI', 'renstra' => $renstra]);
    }

    public function updateVision(Request $request)
    {
        $validated = $request->validate([
            'vision' => 'required|max:255',
        ]);

        $renstra = Renstra::first();
        $renstra->vision = $validated['vision'];
        $renstra->save();

        return redirect()->route('vision.index')->with('success', 'Visi berhasil diperbarui.');
    }

    public function mission()
    {
        $renstra = Renstra::with('missions')->first();
        return view('app.mission', ['title' => 'Misi', 'renstra' => $renstra]);
    }

    public function storeMission(Request $request)
    {
        $validatedData = $request->validate([
            'mission.*' => 'required|string|max:255', // Validate each mission input
        ]);
        $renstra = Renstra::first();
        foreach ($validatedData['mission'] as $data)
            RenstraMission::create(['renstra_id' => $renstra->id, 'description' => $data]);

        return redirect()->route('mission.index')->with('success', 'Berhasil menambahkan misi.');
    }

    public function updateMission(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:renstra_missions,id',
            'description' => 'required|string|max:255'
        ]);

        $mission = RenstraMission::find($validatedData['id']);
        if ($mission) {
            $mission->update(['description' => $validatedData['description']]);
            return response()->json(['success' => 'Misi berhasil diperbarui.']);
        }

        return response()->json(['error' => 'Misi tidak ditemukan.'], 404);
    }

    public function deleteMission(Request $request)
    {
        RenstraMission::find($request->id)->delete();
        return response()->json(['success' => 'Berhasil menghapus misi.']);
    }

    public function iku()
    {
        $renstra = Renstra::first();
        $missions = RenstraMission::get();
        $ikus = RenstraIndicator::with('mission')->get();
        // dd($ikus);

        return view('app.iku', ['title' => 'Indikator Kinerja Utama', 'renstra' => $renstra, 'missions' => $missions, 'ikus' => $ikus]);
    }

    public function storeIku(Request $request)
    {
        $validatedData = $request->validate([
            'iku.*' => 'required|string', // Validate each iku input
            'misi' => 'required|integer', // Validate each iku input
        ]);
        foreach ($validatedData['iku'] as $data)
            RenstraIndicator::create(['renstra_mission_id' => $validatedData['misi'], 'description' => $data]);
        return redirect()->route('iku.index')->with('success', 'IKU berhasil ditambahkan.');
    }
    // Add this method to your RenstraController

    public function deleteIku(Request $request)
    {

        RenstraIndicator::find($request->id)->delete();
        return response()->json(['success' => 'Berhasil menghapus indikator.']);
    }

    public function getRenstraIku(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10); // Default to 10 if not provided

        $query = RenstraIndicator::query();

        if (!empty($search)) {
            $query->where('description', 'LIKE', "%{$search}%");
        }

        $programTargets = $query->limit($limit)->get(['id', 'description']);

        return response()->json($programTargets);
    }

    // fungsi download pdf
    public function downloadMissionPdf()
    {
        $missions = RenstraMission::all();

        // Mendapatkan tanggal dan waktu saat ini
        $date = Carbon::now()->format('Y-m-d_H-i-s');

        // Update the path to match the location of your Blade file
        $pdf = PDF::loadView('components.custom.pdf.downloadMissionPdf', ['missions' => $missions]);
        return $pdf->download("Mission-Report-{$date}.pdf");
    }
    public function downloadIkuPdf()
    {
        $ikus = RenstraIndicator::with('mission')->get();

        // Mendapatkan tanggal dan waktu saat ini
        $date = Carbon::now()->format('Y-m-d_H-i-s');

        // Update the path to match the location of your Blade file
        $pdf = PDF::loadView('components.custom.pdf.downloadIkuPdf', ['ikus' => $ikus]);
        return $pdf->download("IKU-Report-{$date}.pdf");
    }

    // fungsi download excel
    public function downloadMissionExcel()
    {
        // Mendapatkan tanggal dan waktu saat ini
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');

        // Membuat nama file dengan timestamp
        $filename = "Mission-Report-{$timestamp}.xlsx";

        return Excel::download(new MissionsExport, $filename);
    }
    public function downloadIkuExcel()
    {
        // Mendapatkan tanggal dan waktu saat ini
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');

        // Membuat nama file dengan timestamp
        $filename = "IKU-Report-{$timestamp}.xlsx";

        return Excel::download(new IkusExport, $filename);
    }

}
