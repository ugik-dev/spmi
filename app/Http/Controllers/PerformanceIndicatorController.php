<?php

namespace App\Http\Controllers;

use App\Models\PerformanceIndicator;
use App\Models\ProgramTarget;
use App\Exports\PerformanceIndicatorExport;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class PerformanceIndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programTargetsHasPerformanceIndicators = ProgramTarget::has('performanceIndicators')->with('performanceIndicators')->paginate();
        $title = 'Sasaran Program';

        return view('app.performance-indicator', compact('title', 'programTargetsHasPerformanceIndicators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'program_target_id' => 'required|exists:program_targets,id',
            'performance_indicator.*' => 'required|string', // Validate each indicator
            'value' => 'required|decimal:2',
        ]);

        // Retrieve the program target ID from the request
        $programTargetId = $request->program_target_id;

        // Process each performance indicator
        foreach ($request->performance_indicator as $indicator) {
            // Create new PerformanceIndicator
            $performanceIndicator = new PerformanceIndicator([
                'name' => $indicator,
                'program_target_id' => $programTargetId,
                'value' => $request->value,
                // 'value' can be set here if needed, or use default value from migration
            ]);

            // Save the performance indicator to the database
            $performanceIndicator->save();
        }

        // Redirect or send a response back
        return redirect()->route('performance_indicator.index')->with('success', 'Indikator kinerja berhasil disimpan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerformanceIndicator $performanceIndicator)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|decimal:2',
        ]);

        // Update the performance indicator
        $performanceIndicator->name = $request->name;
        $performanceIndicator->value = $request->value;
        $performanceIndicator->save();

        // Redirect with a success message
        return redirect()->route('performance_indicator.index')->with('success', 'Indikator kinerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerformanceIndicator $performanceIndicator)
    {
        // Delete the ProgramTarget instance
        $performanceIndicator->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Indikator kinerja berhasil dihapus.');
    }

    // download pdf
    public function downloadPerformanceIndicatorPdf()
    {
        $programTargetsHasPerformanceIndicators = ProgramTarget::has('performanceIndicators')->with('performanceIndicators')->get();

        // Mendapatkan tanggal dan waktu saat ini
        $date = Carbon::now()->format('Y-m-d_H-i-s');

        $pdf = PDF::loadView('components.custom.pdf.downloadPerformanceIndicatorPdf', compact('programTargetsHasPerformanceIndicators'));
        return $pdf->download("Performance-Indicators-Report-{$date}.pdf");
    }

    // download excel
    public function downloadPerformanceIndicatorExcel()
    {
        // Mendapatkan tanggal dan waktu saat ini
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');

        // Membuat nama file dengan timestamp
        $filename = "Performance-Indicators-Report-{$timestamp}.xlsx";

        return Excel::download(new PerformanceIndicatorExport, $filename);
    }
}
