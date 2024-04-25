<?php

namespace App\Http\Controllers;

use App\Models\AccountCode;
use App\Models\Activity;
use App\Models\BudgetImplementation;
use App\Models\BudgetImplementationDetail;
use App\Models\Dipa;
use App\Models\ExpenditureUnit;
use App\Models\PerformanceIndicator;
use App\Models\UnitBudget;
use App\Services\BudgetImplementationInputArrayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
        $unitBudget = UnitBudget::find(Auth::user()->employee->work_unit_id ?? false);
        $totalSum = 0;
        $dipas = Dipa::where('work_unit_id', Auth::user()->employee->work_unit_id)->get();
        return view('app.budget-implementation-list', compact('title', 'dipas', 'unitBudget',));
    }
    public function create()
    {
        $title = 'Buat DIPA';
        $unitBudget = UnitBudget::find(Auth::user()->employee->work_unit_id ?? false);
        $totalSum = 0;
        $groupedBI = [];
        $dipa = null;
        $accountCodes = AccountCode::all();
        $indikatorPerkin = PerformanceIndicator::all();
        $expenditureUnits = ExpenditureUnit::all();
        return view('app.budget-implementation', compact('title', 'dipa', 'groupedBI', 'accountCodes', 'expenditureUnits', 'totalSum', 'unitBudget', 'indikatorPerkin'));
    }

    public function ajukan(Dipa $dipa)
    {
        $dipa->status = 'on-verification';
        $dipa->save();
        return response()->json(['message' => 'Success']);
    }
    public function dipa(Dipa $dipa)
    {
        $dipa->bi;
        $groupedBI = BudgetImplementation::getGroupedDataWithTotals($dipa->id);
        $title = 'Daftar DIPA';
        $unitBudget = UnitBudget::find(Auth::user()->employee->work_unit_id ?? false);
        $totalSum = BudgetImplementationDetail::CountTotal($dipa->id);
        $accountCodes = AccountCode::all();
        $indikatorPerkin = PerformanceIndicator::all();
        $expenditureUnits = ExpenditureUnit::all();
        return view('app.budget-implementation', compact('title', 'dipa', 'groupedBI', 'accountCodes', 'expenditureUnits', 'totalSum', 'unitBudget', 'indikatorPerkin'));
    }

    public function form()
    {
        $title = 'DIPAs';
        $unitBudget = UnitBudget::find(Auth::user()->employee->work_unit_id ?? false);
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
            'dipa.*.activity.performance_indicator_id' => 'required|integer',
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
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $dipa_id = Dipa::create(['year' => date('Y'), 'work_unit_id' => Auth::user()->employee->work_unit_id])->id;
            $data = $validator->validated()['dipa'];
            // dd($data);
            foreach ($data as $key_ac => $activity) {
                $activity_id = Activity::create([
                    'dipa_id' => $dipa_id,
                    'performance_indicator_id' => $activity['activity']['performance_indicator_id'],
                    'code' => $activity['activity']['code'],
                    'name' => $activity['activity']['name'],
                ])->id;
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
                    }
                    // dd($budgetImplementation);
                }
            }
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
            'dipa.*.activity.performance_indicator_id' => 'required|integer',
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
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $dipa_id = $dipa->id;
            $data = $validator->validated()['dipa'];
            foreach ($data as $key_ac => $activity) {
                if (!empty($activity['bi'])) {
                    Activity::where('id', $activity['activity']['id'])->update([
                        'performance_indicator_id' => $activity['activity']['performance_indicator_id'],
                        'code' => $activity['activity']['code'],
                        'name' => $activity['activity']['name'],
                    ]);
                    $activity_id = $activity['activity']['id'];
                } else {
                    $activity_id = Activity::create([
                        'dipa_id' => $dipa_id,
                        'performance_indicator_id' => $activity['activity']['performance_indicator_id'],
                        'code' => $activity['activity']['code'],
                        'name' => $activity['activity']['name'],
                    ])->id;
                }
                foreach ($activity['accounts'] as $account) {
                    // dd($account);
                    $accountCodeId = null;
                    if ($account) {
                        $accountCode = AccountCode::where('code', $account['account']['code'])->firstOrFail();
                        $accountCodeId = $accountCode->id;
                    }
                    // dd($activity->id);

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

                    // dd('s');
                    foreach ($account['expenditures'] as $detail) {
                        $budget_detail_att = [
                            'budget_implementation_id' => $budgetImplementation->id,
                            'expenditure_unit_id' => ExpenditureUnit::where('code', $detail['unit'])->first()->id,
                            'name' => $detail['description'],
                            'volume' => $detail['volume'],
                            'price' => $detail['unit_price'],
                            'total' => $detail['total'],
                        ];
                        if (!isset($detail['id']) && empty($detail['id'])) {
                            BudgetImplementationDetail::create($budget_detail_att);
                        } else {
                            BudgetImplementationDetail::where('id', $detail['id'])->update($budget_detail_att);
                        }
                    }
                    // dd($budgetImplementation);
                }
            }
            // dd($data[0]['activity']);
            // dd();
            // return response()->json($this->budgetService->process($validator->validated()['dipa']));
        } catch (\Exception $e) {
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
                    $budgetImplementationDetail = BudgetImplementationDetail::findOrFail($validatedData['id']);
                    $budgetImplementationDetail->name = $validatedData['name'];
                    $budgetImplementationDetail->volume = $validatedData['volume'];
                    $budgetImplementationDetail->price = $validatedData['unit_price'];
                    $budgetImplementationDetail->total = $validatedData['total'];
                    $budgetImplementationDetail->expenditureUnit()->associate($expenditureUnit);
                    $budgetImplementationDetail->save();

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
}
