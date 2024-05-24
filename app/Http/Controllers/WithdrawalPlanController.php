<?php

namespace App\Http\Controllers;

use App\Enums\Month;
use App\Models\Activity;
use App\Models\Dipa;
use App\Models\WithdrawalPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WithdrawalPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function open(Dipa $dipa)
    {
        $title = 'Rencana Penarikan Dana';
        $activities = Activity::with('withdrawalPlans')->sortedByCode()->where('dipa_id', $dipa->id)->get();
        // dd($activities); 
        $months = Month::cases(); // Assuming you have a Month Enum with cases for each month
        return view('app.withdrawal-plan', compact('title', 'activities', 'months', 'dipa'));
    }
    public function index()
    {
        if (empty(Auth::user()->employee->work_unit_id)) {
            return view('errors.405', ['pageTitle' => "Error", 'message' => "Unit Kerja anda belum diatur, harap hubungi admin!!"]);
        }
        $title = 'Daftar DIPA';
        $totalSum = 0;
        $timelines = [];
        $timelinesPra = [];
        $dipas = Dipa::where('work_unit_id', Auth::user()->employee->work_unit_id)->get();
        $btnRPD = true;
        return view('app.budget-implementation-list', compact('title', 'dipas', 'timelines', 'timelinesPra', 'btnRPD'));
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
        try {
            $validatedData = $request->validate([
                'activityId' => 'required|integer|exists:activities,id',
                'withdrawalPlans' => 'required|array',
                'withdrawalPlans.*.month' => 'required|integer|min:1|max:12',
                'withdrawalPlans.*.amount_withdrawn' => 'required|numeric|min:0',
                'year' => 'required|integer|digits:4',
            ]);

            foreach ($validatedData['withdrawalPlans'] as $planData) {
                $monthEnum = Month::from($planData['month']);

                WithdrawalPlan::updateOrCreate(
                    [
                        'activity_id' => $validatedData['activityId'],
                        'month' => $monthEnum,
                    ],
                    [
                        'amount_withdrawn' => $planData['amount_withdrawn'],
                    ]
                );
            }

            return response()->json(['message' => 'Data penarikan dana berhasil disimpan']);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WithdrawalPlan $withdrawalPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WithdrawalPlan $withdrawalPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WithdrawalPlan $withdrawalPlan)
    {
        $validatedData = $request->validate([
            'activityId' => 'required|integer|exists:activities,id',
            'withdrawalPlans' => 'required|array',
            'withdrawalPlans.*.month' => 'required|integer|min:1|max:12',
            'withdrawalPlans.*.amount_withdrawn' => 'required|numeric|min:0',
        ]);

        foreach ($validatedData['withdrawalPlans'] as $planData) {
            $monthEnum = Month::from($planData['month']);

            WithdrawalPlan::updateOrCreate(
                [
                    'activity_id' => $validatedData['activityId'],
                    'month' => $monthEnum,
                ],
                [
                    'amount_withdrawn' => $planData['amount_withdrawn'],
                ]
            );
        }

        return response()->json(['message' => 'Data penarikan dana berhasil disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WithdrawalPlan $withdrawalPlan)
    {
        //
    }

    /**
     * Get withdrawal plans for a specific activity.
     *
     * @param  int  $activityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithdrawalPlans($activityId)
    {

        $withdrawalPlans = WithdrawalPlan::where('activity_id', $activityId)
            ->get();

        return response()->json($withdrawalPlans);
    }

    public function getWithdrawalPlansDetail($activityId)
    {
        $activity = Activity::find($activityId);
        $withdrawalPlans = WithdrawalPlan::where('activity_id', $activityId)
            ->get();

        return response()->json(['activity' => $activity, 'data' => $withdrawalPlans, 'totalPlan' => $withdrawalPlans->sum('amount_withdrawn'), 'totalActivity' => $activity->calculateTotalSum()]);
    }
}
