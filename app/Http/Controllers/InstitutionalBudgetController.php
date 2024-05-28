<?php

namespace App\Http\Controllers;

use App\Models\InstitutionalBudget;
use App\Models\PaguLembaga;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;

class InstitutionalBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Pagu Lembaga';
        $institutionalBudget = InstitutionalBudget::first();
        $pagus = PaguLembaga::get();

        return view('app.pagu', compact('title', 'pagus'));
        // return view('app.institutional-budget', compact('title', 'institutionalBudget'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Preprocess 'pagu' input: remove 'Rp' and commas, then convert to integer
        $paguInput = $request->input('nominal');
        $cleanedPagu = intval(str_replace(['Rp', '.'], '', $paguInput));

        // Validate the request
        $validatedData = $request->validate([
            'id' => 'nullable|exists:pagu_lembagas,id',
            'year' => 'required|date_format:Y',
        ]);

        // $institutionalBudget = InstitutionalBudget::findOrNew($validatedData['ins_budget_id'] ?? null);
        PaguLembaga::updateOrCreate(
            [
                'year' => $validatedData['year']
            ],
            [
                'nominal' =>    $cleanedPagu
            ],
            // Values to update or create
        );
        // Update or set the 'pagu' field with the cleaned value
        // $institutionalBudget->pagu = $cleanedPagu;
        // $institutionalBudget->save();

        // // Add a response for successful creation or update
        return response()->json(['error' => false,  'message' => 'Success'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InstitutionalBudget $institutionalBudget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstitutionalBudget $institutionalBudget)
    {
        //
    }

    // fungsi export pdf
    public function downloadPaguPdf()
    {
        $pagus = PaguLembaga::all();

        // Mendapatkan tanggal dan waktu saat ini
        $date = Carbon::now()->format('Y-m-d_H-i-s');

        $pdf = PDF::loadView('components.custom.pdf.downloadPaguPdf', ['pagus' => $pagus]);
        return $pdf->download("Pagu_Lembaga_PDF_{$date}.pdf");
    }

}
