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

    public function index()
    {
        $title = 'Dashboard';
        $timelines = Timeline::orderBy('start')->get();
        $timelinesActive = Timeline::active()->first();
        $waitinglist = Dipa::Accessibility(true)->get();
        $unitBudget = PaguUnit::unityear(date('Y'), Auth::user()->employee->work_unit_id ?? false)->first();

        $paguLembaga = PaguLembaga::where('year', '=', date('Y'))->firstOrFail();
        $workUnits = WorkUnit::with('unitBudgets', 'paguUnit')
            ->with(['paguUnit' => function ($q) use ($paguLembaga) {
                $q->where('pagu_lembaga_id', $paguLembaga->id);
            }])
            ->get();
        $chartPagu['name'] = [];
        $chartPagu['pagu'] = [];
        $chartPagu['realisasi'] = [];
        foreach ($workUnits as $workUnit) {
            $chartPagu['name'][] = $workUnit->name;
            $chartPagu['pagu'][] = $workUnit->paguUnit->first()->nominal;
            $chartPagu['realisasi'][] =  $workUnit->paguUnit->first()->nominal;
        }
        // dd($chartPagu);
        return view('app.dashboard', compact('title', 'chartPagu', 'timelines', 'waitinglist', 'unitBudget', 'timelinesActive'));
    }
}
