<?php

namespace App\Http\Controllers;


use App\Models\AccountCode;
use App\Models\Activity;
use App\Models\BudgetImplementation;
use App\Models\BudgetImplementationDetail;
use App\Models\Dipa;
use App\Models\DipaLog;
use App\Models\ExpenditureUnit;
use App\Models\IKSK;
use App\Models\PaguUnit;
use App\Models\PerformanceIndicator;
use App\Models\Timeline;
use App\Models\UnitBudget;
use App\Services\BudgetImplementationInputArrayService;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class BudgetImplementationController extends Controller
{
    protected $budgetService;

    public function __construct(BudgetImplementationInputArrayService $budgetService)
    {
        $this->budgetService = $budgetService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Daftar DIPA';
        $btnExport = [
            'pdf' => true,
            'exl_simple' => true,
            'exl_mapping' => true,
        ];
        $timelines = Timeline::active('creat')->get();
        $timelinesPra = Timeline::active('pra-creat')->get();
        $totalSum = 0;
        if (empty(Auth::user()->employee->work_unit_id)) {
            return view('errors.405', ['pageTitle' => "Error", 'message' => "Unit Kerja anda belum diatur, harap hubungi admin!!"]);
        }
        $dipas = Dipa::with('timeline')->where('work_unit_id', Auth::user()->employee->work_unit_id)->latest('year', 'revision')->get();
        $btnCreate = true;
        return view('app.budget-implementation-list', compact('title', 'dipas', 'timelines', 'timelinesPra', 'btnExport', 'btnCreate',));
    }
    public function create(Timeline $timeline)
    {
        $currentDateTime = Carbon::now(); // Get the current date and time

        $timeline = Timeline::active(['creat', 'pra-creat'], $timeline->id)
            ->first();
        // dd($timeline);
        if (empty($timeline)) {
            return view('errors.405', ['pageTitle' => "Error", 'message' => "Bukan masa pembuatan usulan Dipa"]);
        }
        // $check_dipa = Dipa::where('year', '=', $timeline->year)->where('work_unit_id', '=', Auth::user()->employee->work_unit_id)->first();
        $check_dipa = Dipa::where('timeline_id', '=', $timeline->id)->where('work_unit_id', '=', Auth::user()->employee->work_unit_id)->first();
        if (!empty($check_dipa)) {
            return view('errors.405', ['pageTitle' => "Error", 'message' => "Dipa untuk periode ini sudah pernah dibuat"]);
        }
        if ($timeline->category == 'creat') {
            $praTimeline = Timeline::where('year', '=', $timeline->year)->where('category', '=', 'pra-creat')->first();
            if (!empty($praTimeline->id))
                $praDipa = Dipa::where('timeline_id', $praTimeline->id)->where('work_unit_id', '=', Auth::user()->employee->work_unit_id)->latest('revision')->first();
            else
                $praDipa = false;
        }
        $title = 'Buat DIPA';
        $unitBudget = PaguUnit::unityear($timeline->year, Auth::user()->employee->work_unit_id ?? false)->first();

        if (!empty($praDipa)) {
            $totalSum = BudgetImplementationDetail::CountTotal($praDipa->id);
            $groupedBI = BudgetImplementation::getGroupedDataWithTotals($praDipa->id);
            // $copy_of = $newDipa->id;
            $dipa = null;
        } else {
            $totalSum = 0;
            $groupedBI = [];
            $dipa = null;
        }
        $btnExport = [];
        $accountCodes = AccountCode::all();
        $indikatorPerkin = IKSK::all();
        $expenditureUnits = ExpenditureUnit::all();
        return view('app.budget-implementation', compact('title', 'timeline', 'dipa', 'btnExport', 'groupedBI', 'accountCodes', 'expenditureUnits', 'totalSum', 'unitBudget', 'indikatorPerkin'));
    }


    public function dipa(Dipa $dipa)
    {
        $dipa->bi;
        $dipa->unit;
        $groupedBI = BudgetImplementation::getGroupedDataWithTotals($dipa->id);
        $title = 'Daftar DIPA';
        $unitBudget = PaguUnit::unityear($dipa->year, $dipa->work_unit_id)->first();
        // dd($groupedBI);
        $totalSum = BudgetImplementationDetail::CountTotal($dipa->id);
        $btnExport = [
            'pdf' => true,
            'exl_simple' => true,
            'exl_mapping' => true,
        ];
        $accountCodes = AccountCode::all();
        $indikatorPerkin = IKSK::all();
        $expenditureUnits = ExpenditureUnit::all();
        return view('app.budget-implementation', compact('title', 'dipa', 'groupedBI', 'accountCodes', 'btnExport', 'expenditureUnits', 'totalSum', 'unitBudget', 'indikatorPerkin'));
    }
    public function create_copy(Dipa $dipa)
    {
        $currentDateTime = Carbon::now(); // Get the current date and time

        $timeline = Timeline::active('revision')
            ->where('year', '=', $dipa->year)
            ->first();
        if (empty($timeline)) {
            return view('errors.405', ['pageTitle' => "Error", 'message' => "Bukan Waktu untuk revisi"]);
        }
        $newDipa = Dipa::where('year', $dipa->year)->where('work_unit_id', '=', $dipa->work_unit_id)->latest('revision')->first();
        $title = 'Buat DIPA';
        $unitBudget = PaguUnit::unityear($dipa->year, Auth::user()->employee->work_unit_id ?? false)->first();
        $totalSum = BudgetImplementationDetail::CountTotal($newDipa->id);
        $groupedBI = BudgetImplementation::getGroupedDataWithTotals($newDipa->id);
        // dd($groupedBI);
        $btnExport = [];
        $copy_of = $newDipa->id;
        $dipa = null;
        $accountCodes = AccountCode::all();
        $indikatorPerkin = IKSK::all();
        $expenditureUnits = ExpenditureUnit::all();
        return view('app.budget-implementation', compact('title', 'timeline', 'btnExport', 'copy_of', 'dipa', 'groupedBI', 'accountCodes', 'expenditureUnits', 'totalSum', 'unitBudget', 'indikatorPerkin'));
    }
    public function form()
    {
        $title = 'DIPAs';
        $unitBudget = UnitBudget::where('work_unit_id', Auth::user()->employee->work_unit_id ?? false);
        $totalSum = 0;
        $groupedBI = [];
        $accountCodes = AccountCode::all();
        $indikatorPerkin = PerformanceIndicator::all();
        $expenditureUnits = ExpenditureUnit::all();
        return view('app.budget-implementation', compact('title', 'groupedBI', 'accountCodes', 'expenditureUnits', 'totalSum', 'unitBudget', 'indikatorPerkin'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'dipa.*.bi' => 'sometimes|integer',
            'dipa.*.activity.id' => 'sometimes|integer',
            'dipa.*.activity.performance_indicator_id' => 'nullable|integer',
            'dipa.*.activity.code' => 'required|string',
            'dipa.*.activity.name' => 'required|string',
            'dipa.*.accounts' => 'nullable|array',
            'dipa.*.accounts.*.account.id' => 'sometimes|string',
            'dipa.*.accounts.*.account.code' => 'required|string',
            'dipa.*.accounts.*.account.name' => 'required|string',
            'dipa.*.accounts.*.expenditures' => 'sometimes|array',
            'dipa.*.accounts.*.expenditures.*.id' => 'sometimes|string',
            'dipa.*.accounts.*.expenditures.*.budget_implementation' => 'sometimes|string',
            'dipa.*.accounts.*.expenditures.*.description' => 'required|string',
            'dipa.*.accounts.*.expenditures.*.volume' => 'required|numeric',
            'dipa.*.accounts.*.expenditures.*.unit' => 'required|string',
            'dipa.*.accounts.*.expenditures.*.unit_price' => 'required|numeric',
            'dipa.*.accounts.*.expenditures.*.total' => 'required|numeric',
            'copy_of' => 'sometimes|numeric',
            'timeline' => 'sometimes|numeric',
        ]);

        // dd($validator->validated()['copy_of']);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $data = $validator->validated()['dipa'];
            $currentDateTime = Carbon::now();
            $copy = false;
            if (!empty($validator->validated()['copy_of'])) {
                $copy = $validator->validated()['copy_of'];
                $copyData = Dipa::find($validator->validated()['copy_of']);

                $timelines = Timeline::where('start', '<=', $currentDateTime)
                    ->where('end', '>=', $currentDateTime)->where('category', '=', 'revision')
                    ->where('year', '=', $copyData->year)
                    ->first();
                if (empty($timelines)) {
                    return response()->json(['error' => "Bukan masa revisi"], 500);
                }

                $last = Dipa::where('head_id', !empty($copyData->head_id) ? $copyData->head_id : $copyData->id)->latest()->first();
                if (!empty($last)) {
                    $revision = $last->revision + 1;
                } else {
                    $revision = 1;
                }
                // dd($copyData->);
                // dd($revision, $last);
                $dipa_id = Dipa::create(['year' => $timelines->year, 'timeline_id' => $timelines->id, 'revision' => $revision, 'head_id' => !empty($copyData->head_id) ? $copyData->head_id : $copyData->id, 'total' => 0, 'work_unit_id' => Auth::user()->employee->work_unit_id, 'user_id' => Auth::user()->id])->id;
            } else {
                $timelines = Timeline::active(['creat', 'pra-creat'], $validator->validated()['timeline'])
                    ->first();
                if (empty($timelines)) {
                    return response()->json(['error' => "Bukan masa pembuatan dipa"], 500);
                }
                // $check_dipa = Dipa::where('year', '=', $timelines->year)->where('work_unit_id', '=', Auth::user()->employee->work_unit_id)->first();
                $check_dipa = Dipa::where('timeline_id', '=', $timelines->id)->where('work_unit_id', '=', Auth::user()->employee->work_unit_id)->first();
                if (!empty($check_dipa)) {
                    return response()->json(['error' => "Dipa periode ini sudah dibuat"], 500);
                }
                $dipa_id = Dipa::create(['year' => $timelines->year, 'timeline_id' => $timelines->id, 'total' => 0, 'work_unit_id' => Auth::user()->employee->work_unit_id, 'user_id' => Auth::user()->id])->id;
            }
            // dd($copy);
            // dd($data);
            $total = 0;
            foreach ($data as $key_ac => $activity) {
                if (!empty($activity['accounts'])) {
                    $activity_id = Activity::create([
                        'dipa_id' => $dipa_id,
                        'performance_indicator_id' => $activity['activity']['performance_indicator_id'],
                        'code' => strtoupper($activity['activity']['code']),
                        'name' => $activity['activity']['name'],
                    ])->id;
                    if (!empty($copyData))
                        Dipa::copyActivity($activity_id, strtoupper($activity['activity']['code']), $activity['activity']['name'], $copyData->id);
                }
                foreach ($activity['accounts'] as $account) {
                    $accountCodeId = null;
                    if ($account) {
                        $accountCode = AccountCode::where('code', $account['account']['code'])->firstOrFail();
                        $accountCodeId = $accountCode->id;
                    }
                    $budgetImplementation = BudgetImplementation::create(
                        [
                            'dipa_id' => $dipa_id,
                            'activity_id' => $activity_id,
                            'account_code_id' => $accountCodeId,
                        ],
                    );
                    foreach ($account['expenditures'] as $detail) {
                        BudgetImplementationDetail::create([
                            'budget_implementation_id' => $budgetImplementation->id,
                            'expenditure_unit_id' => ExpenditureUnit::where('code', $detail['unit'])->first()->id,
                            'name' => $detail['description'],
                            'volume' => $detail['volume'],
                            'price' => $detail['unit_price'],
                            'total' => $detail['total'],
                        ]);
                        $total = $total + $detail['total'];
                    }
                    // dd($budgetImplementation);
                }
            }
            Dipa::where('id', $dipa_id)->update(['total' => $total]);

            // dd($data[0]['activity']);
            // return response()->json($this->budgetService->process($validator->validated()['dipa']));
        } catch (\Exception $e) {
            Log::error('Error in store function: ' . $e->getMessage());

            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Success', 'id' => $dipa_id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update_dipa(Request $request, Dipa $dipa)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'dipa.*.bi' => 'sometimes|integer',
            'dipa.*.activity.id' => 'sometimes|integer',
            'dipa.*.activity.performance_indicator_id' => 'nullable|integer',
            'dipa.*.activity.code' => 'required|string',
            'dipa.*.activity.name' => 'required|string',
            'dipa.*.accounts' => 'nullable|array',
            'dipa.*.accounts.*.account.bi' => 'sometimes|string',
            'dipa.*.accounts.*.account.id' => 'sometimes|string',
            'dipa.*.accounts.*.account.code' => 'required|string',
            'dipa.*.accounts.*.account.name' => 'required|string',
            'dipa.*.accounts.*.expenditures' => 'sometimes|array',
            'dipa.*.accounts.*.expenditures.*.id' => 'sometimes|string',
            'dipa.*.accounts.*.expenditures.*.budget_implementation' => 'sometimes|string',
            'dipa.*.accounts.*.expenditures.*.description' => 'required|string',
            'dipa.*.accounts.*.expenditures.*.volume' => 'required|numeric',
            'dipa.*.accounts.*.expenditures.*.unit' => 'required|string',
            'dipa.*.accounts.*.expenditures.*.unit_price' => 'required|numeric',
            'dipa.*.accounts.*.expenditures.*.total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $dipa_id = $dipa->id;
            $data = $validator->validated()['dipa'];
            // dd($data);
            $total = 0;
            foreach ($data as $key_ac => $activity) {
                if (!empty($activity['bi'])) {
                    Activity::where('id', $activity['activity']['id'])->update([
                        'dipa_id' => $dipa_id,
                        'performance_indicator_id' => $activity['activity']['performance_indicator_id'],
                        'code' => strtoupper($activity['activity']['code']),
                        'name' => $activity['activity']['name'],
                    ]);
                    $activity_id = $activity['activity']['id'];
                } else {
                    if (!empty($activity['accounts']))
                        $activity_id = Activity::create([
                            'dipa_id' => $dipa_id,
                            'performance_indicator_id' => $activity['activity']['performance_indicator_id'],
                            'code' => strtoupper($activity['activity']['code']),
                            'name' => $activity['activity']['name'],
                        ])->id;
                }
                // dd($activity['accounts'][0]);
                foreach ($activity['accounts'] as $account) {
                    // dd($account);
                    $accountCodeId = null;
                    if ($account) {
                        $accountCode = AccountCode::where('code', $account['account']['code'])->firstOrFail();
                        $accountCodeId = $accountCode->id;
                    }
                    // dd($activity->id);
                    if (empty($account['account']['bi'])) {
                        // dd($account);
                        // dd('here');
                        $budgetImplementation = BudgetImplementation::firstOrCreate(
                            [
                                'dipa_id' => $dipa->id,
                                'revision' => $dipa->revision,
                                'activity_id' => $activity_id,
                                'account_code_id' => $accountCodeId,
                            ],
                            [
                                'dipa_id' => $dipa->id,
                                'revision' => $dipa->revision,
                                'activity_id' => $activity_id,
                                'account_code_id' => $accountCodeId,
                            ]
                        );
                        $account['account']['bi'] = $budgetImplementation->id;
                    } else {
                        $budgetImplementation = BudgetImplementation::findOrFail($account['account']['bi']);
                        if ($budgetImplementation->account_code_id != $accountCodeId)
                            BudgetImplementation::where('id', $account['account']['bi'])->update([
                                'account_code_id' => $accountCodeId,
                            ]);
                    }

                    // dd('s');
                    foreach ($account['expenditures'] as $detail) {
                        $budget_detail_att = [
                            'budget_implementation_id' => $account['account']['bi'],
                            'expenditure_unit_id' => ExpenditureUnit::where('code', $detail['unit'])->first()->id,
                            'name' => $detail['description'],
                            'volume' => $detail['volume'],
                            'price' => $detail['unit_price'],
                            'total' => $detail['total'],
                        ];
                        $total = $total + $detail['total'];

                        if (!isset($detail['id']) && empty($detail['id'])) {
                            BudgetImplementationDetail::create($budget_detail_att);
                        } else {
                            BudgetImplementationDetail::where('id', $detail['id'])->update($budget_detail_att);
                        }
                    }
                    // dd($budgetImplementation);
                }
            }
            Dipa::where('id', $dipa_id)->update(['total' => $total]);
            // dd($data[0]['activity']);
            // dd();
            // return response()->json($this->budgetService->process($validator->validated()['dipa']));
        } catch (\Exception $e) {
            // dd($key_ac, $activity, $budgetImplementation, $accountCodeId, 'C', $account['account']['code']);
            Log::error('Error in store function: ' . $e->getMessage());

            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Success']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'type' => 'required|in:activity,account,detail',
            'id' => 'required|integer',
            'performance_indicator_id' => 'sometimes|integer',
            'code' => 'sometimes|string',
            'name' => 'sometimes|string|max:255',
            'volume' => 'sometimes|integer',
            'unit' => 'sometimes|string|max:255',
            'unit_price' => 'sometimes|string',
            'total' => 'sometimes|string',
        ]);
        // dd($validatedData);
        try {
            switch ($validatedData['type']) {
                case 'activity':
                    // dd($validatedData);

                    $budgetImplementation = BudgetImplementation::findOrFail($validatedData['id']);
                    // $activity = Activity::updateOrCreate(
                    //     ['code' => $validatedData['code']],
                    //     ['name' => $validatedData['name'], 'performance_indicator_id' => $validatedData['performance_indicator_id']],
                    // );

                    $activity = Activity::where('id', $budgetImplementation->activity_id)->update(
                        [
                            'code' => $validatedData['code'],
                            'name' => $validatedData['name'],
                            'performance_indicator_id' => $validatedData['performance_indicator_id']
                        ]
                    );

                    // dd($activity);

                    // $budgetImplementation->activity()->associate($activity)->save();

                    return back()->with(['success' => 'Berhasil memperbarui data detail']);
                    break;

                case 'account':
                    $budgetImplementation = BudgetImplementation::findOrFail($validatedData['id']);
                    $accountCode = AccountCode::firstWhere('code', $validatedData['code']);
                    // dd($accountCode->id);
                    $activity = BudgetImplementation::where('id', $budgetImplementation->id)->update(
                        [
                            'account_code_id' =>  $accountCode->id,
                        ]
                    );
                    // dd($activity);

                    // $budgetImplementation->accountCode()->associate($accountCode)->save();

                    return back()->with(['success' => 'Berhasil memperbarui data dipa']);
                    break;

                case 'detail':
                    $validatedData['unit_price'] = $this->convertToDecimal($validatedData['unit_price']);
                    $validatedData['total'] = $this->convertToDecimal($validatedData['total']);
                    $expenditureUnit = ExpenditureUnit::firstWhere('code', $validatedData['unit']);
                    $budgetImplementationDetail = BudgetImplementationDetail::with('budgetImplementation')->findOrFail($validatedData['id']);
                    $budgetImplementationDetail->name = $validatedData['name'];
                    $budgetImplementationDetail->volume = $validatedData['volume'];
                    $budgetImplementationDetail->price = $validatedData['unit_price'];
                    $budgetImplementationDetail->total = $validatedData['total'];
                    $budgetImplementationDetail->expenditureUnit()->associate($expenditureUnit);
                    $budgetImplementationDetail->save();
                    $totalSum = BudgetImplementationDetail::CountTotal($budgetImplementationDetail->budgetImplementation->dipa_id);
                    Dipa::where('id', $budgetImplementationDetail->budgetImplementation->dipa_id)->update(['total' => $totalSum]);
                    // $dipa->total = $totalSum;
                    return back()->with(['success' => 'Berhasil memperbarui data detail']);
                    break;

                default:
                    return back();
            }
        } catch (\Throwable $th) {
            Log::error($th);

            return back();
        }
    }

    private function convertToDecimal($value)
    {
        // Remove the currency symbol, non-breaking spaces (\u{A0} or &nbsp;), and any regular spaces
        $number = str_replace(['Rp', ' ', "\xc2\xa0"], '', $value);

        // Replace Indonesian thousand separator (dot) with nothing
        $number = str_replace('.', '', $number);

        // Replace Indonesian decimal separator (comma) with a dot
        $number = str_replace(',', '.', $number);

        // Convert to float and format to two decimal places
        return number_format((float) $number, 2, '.', '');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($type, $id)
    {
        if ($type === 'detail') {
            try {
                BudgetImplementationDetail::find($id)->delete();

                return response()->json(['success' => 'true', 'message' => 'Berhasil menghapus data detail dipa.'], 200);
            } catch (\Throwable $th) {
                Log::error($th);

                return response()->json(['error' => 'true', 'message' => $th]);
            }
        }
        if ($type === 'activity') {
            try {
                // Find the BudgetImplementation record by ID
                $budgetImplementation = BudgetImplementation::find($id);

                // Check if the record exists
                if (!$budgetImplementation) {
                    return response()->json(['error' => 'true', 'message' => 'Budget Implementation not found.'], 404);
                }

                // Delete all BudgetImplementation records with the same activity_id
                Activity::find($budgetImplementation->activity_id)->delete();

                return response()->json(['success' => 'true', 'message' => 'Berhasil menghapus data dipa.'], 200);
            } catch (\Throwable $th) {
                Log::error($th);

                return response()->json(['error' => 'true', 'message' => $th->getMessage()], 500);
            }
        }

        try {
            BudgetImplementation::find($id)->delete();

            return response()->json(['success' => 'true', 'message' => 'Berhasil menghapus data dipa.'], 200);
        } catch (\Throwable $th) {
            Log::error($th);

            return response()->json(['error' => 'true', 'message' => $th]);
        }
    }

    public function delete_dipa(Request $request)
    {
        try {
            Dipa::where('id', $request->id)->where('work_unit_id', Auth::user()->employee->work_unit_id)->delete();
            return response()->json(['success' => 'true', 'message' => 'Berhasil menghapus data detail dipa.'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => 'true', 'message' => $th]);
        }
    }
}
