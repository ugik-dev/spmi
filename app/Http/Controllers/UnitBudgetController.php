<?php

namespace App\Http\Controllers;

use App\Models\PaguLembaga;
use App\Models\PaguUnit;
use App\Models\UnitBudget;
use App\Models\WorkUnit;
use Illuminate\Http\Request;
use App\Exports\PaguUnitExport;
use Maatwebsite\Excel\Facades\Excel;

class UnitBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($year)
    {
        $title = 'Pagu Unit';
        $paguLembaga = PaguLembaga::where('year', '=', $year)->firstOrFail();
        $workUnits = WorkUnit::with('unitBudgets', 'paguUnit')
            ->with(['paguUnit' => function ($q) use ($paguLembaga) {
                $q->where('pagu_lembaga_id', $paguLembaga->id);
            }])
            ->get();
        // $workUnits = WorkUnit::select('work_units.*', 'pagu_units.nominal')->rightJoin('pagu_units', 'pagu_units.work_unit_id',  'work_units.id')
        //     ->rightJoin('pagu_lembagas', 'pagu_lembagas.id',  'pagu_units.pagu_lembaga_id')
        //     ->where('pagu_lembagas.id', '=', $paguLembaga->id)
        //     ->get();
        // dd($workUnits);
        // $unitBudgets = UnitBudget::with('workUnit')->get();

        return view('app.pagu-unit', compact('title', 'workUnits', 'paguLembaga'));
    }
    public function excel($year)
    {
        $title = 'Pagu Unit';
        $paguLembaga = PaguLembaga::where('year', '=', $year)->firstOrFail();
        $workUnits = WorkUnit::with('unitBudgets', 'paguUnit')
            ->with(['paguUnit' => function ($q) use ($paguLembaga) {
                $q->where('pagu_lembaga_id', $paguLembaga->id);
            }])
            ->get();

        // dd($workUnits);
        $filename = "pagu-unit-{$paguLembaga->year}.xlsx";
        return Excel::download(new PaguUnitExport($paguLembaga, $workUnits), $filename);
        // return view('app.pagu-unit', compact('title', 'workUnits', 'paguLembaga'));
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
        // dd($request->all());
        foreach ($request->all() as $budgetData) {
            // UnitBudget::updateOrCreate(
            //     ['work_unit_id' => $budgetData['work_unit_id']], // Check for existing record based on work_unit_id
            //     ['pagu' => $budgetData['pagu']] // Values to update or create
            // );

            PaguUnit::updateOrCreate(
                [
                    'work_unit_id' => $budgetData['work_unit_id'],
                    'pagu_lembaga_id' => $budgetData['pagu_lembaga_id']
                ],
                ['nominal' => $budgetData['pagu']] // Values to update or create
            );
        }

        return response()->json(['message' => 'Pagu unit berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitBudget $unitBudget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitBudget $unitBudget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitBudget $unitBudget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitBudget $unitBudget)
    {
        //
    }
}
