<?php

namespace App\Http\Controllers;

use App\Models\Dipa;
use App\Models\PaguLembaga;
use App\Models\PaguUnit;
use App\Models\Timeline;
use App\Models\WorkUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //

    public function index(Request $request)
    {
        if (!empty($request->year)) {
            $year = $request->year;
        } else {
            $year = date('Y');
        }
        $title = 'Dashboard';
        $timelines = Timeline::orderBy('start')->get();
        $timelinesActive = Timeline::active()->first();
        $waitinglist = Dipa::Accessibility(true)->get();
        $unitBudget = PaguUnit::unityear($year, Auth::user()->employee->work_unit_id ?? false)->first();

        $paguLembaga = PaguLembaga::where('year', '=', $year)->firstOrFail();
        $workUnits = WorkUnit::selectRaw('work_units.id,work_units.code,work_units.name, sum(receipts.amount) as realisasi')->with(['paguUnit' => function ($q) use ($paguLembaga) {
            $q->where('pagu_lembaga_id', $paguLembaga->id);
        }])
            ->leftJoin('receipts', function ($join) use ($year) {
                $join->on('receipts.work_unit_id', '=', 'work_units.id')
                    ->whereYear('receipts.activity_date', '=', $year);
            })
            ->groupBy('work_units.id', 'work_units.name', 'work_units.code')
            ->get();
        $chartPagu['name'] = [];
        $chartPagu['code'] = [];
        $chartPagu['pagu'] = [];
        $chartPagu['realisasi'] = [];
        foreach ($workUnits as $workUnit) {
            $chartPagu['name'][] = $workUnit->name;
            $chartPagu['code'][] = $workUnit->code;
            $chartPagu['realisasi'][] = $workUnit->realisasi;
            $chartPagu['pagu'][] = $workUnit->paguUnit->first()->nominal;
            // $chartPagu['realisasi'][] =  $workUnit->paguUnit->first()->nominal;
        }
        // dd($waitinglist);
        return view('app.dashboard', compact('title', 'year', 'chartPagu', 'timelines', 'waitinglist', 'unitBudget', 'timelinesActive'));
    }
}
