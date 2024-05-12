<?php

use App\Http\Controllers\AccountCodeController;
use App\Http\Controllers\AccountCodeReceptionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AssetItemController;
use App\Http\Controllers\BudgetImplementationDetailController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaymentReceiptController;
use App\Http\Controllers\PerformanceIndicatorController;
use App\Http\Controllers\PPKController;
use App\Http\Controllers\ProgramTargetController;
use App\Http\Controllers\SearchEmployeeController;
use App\Http\Controllers\RenstraController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificatorController;
use App\Http\Controllers\WithdrawalPlanController;
use App\Models\PerformanceIndicator;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/verificators', [VerificatorController::class, 'getVerificators'])->name('verificators.index');
    Route::get('/program-targets', [ProgramTargetController::class, 'getProgramTargets'])->name('program_targets.index');
    Route::get('/performance-indicator', [PerformanceIndicatorController::class, 'getPerformanceIndicator'])->name('performance_indicators.index');
    Route::get('/renstra-iku', [RenstraController::class, 'getRenstraIku'])->name('renstra_iku.index');
    Route::get('/employees/heads', [EmployeeController::class, 'getHeads'])->name('employees.heads');
    Route::get('/employees/ppk', [EmployeeController::class, 'searchPPK'])->name('employees.search.ppk');
    Route::get('/employees/treasurer', [EmployeeController::class, 'searchTreasurer'])->name('employees.search.treasurer');
    Route::get('/employees/pelaksana', [EmployeeController::class, 'searchPelaksana'])->name('employees.search.pelaksana');
    Route::get('/employees/pengikut', [EmployeeController::class, 'searchPengikut'])->name('employees.search.pengikut');
    Route::get('/withdrawal-plans/{activityId}', [WithdrawalPlanController::class, 'getWithdrawalPlans'])->name('withdrawal_plans.activity');
    Route::get('/withdrawal-plans-detail/{activityId}', [WithdrawalPlanController::class, 'getWithdrawalPlansDetail'])->name('withdrawal_plans.activity-detail');
    Route::get('/get-activity/{year}', [BudgetImplementationDetailController::class, 'getActivity'])->name('activity.by-year');
    Route::get('/activity/{activityId}/account-codes', [AccountCodeController::class, 'getAccountCodesByActivity'])->name('account_codes.activity');
    Route::get('/details/{activityId}/{accountCodeId}', [BudgetImplementationDetailController::class, 'getByActivityAccountCode'])->name('budget_implementation_details.activity_account_code');
    Route::get('/detail/{budgetImplementationDetail}', [BudgetImplementationDetailController::class, 'show'])->name('detail.show');
    Route::get('/account-code-receptions', [AccountCodeReceptionController::class, 'getAccountCodes'])->name('account_code_receptions.index');
    Route::get('/selected-account-code-reception/{accountCodeReception}', [AccountCodeReceptionController::class, 'getSelectedAccountCode'])->name('account_code_receptions.selected');
    Route::get('/asset-items/{category?}', [AssetItemController::class, 'getAssetItemBySelectedCategory'])->name('asset_items.selected_category');
    // Get Receipt Total Amount By Budget Implementation Detail ID
    Route::get('/receipt/total-amount/{detail}', [PaymentReceiptController::class, 'totalAmountByBudgetImplementationDetail'])->name('receipts.total_amount');
    Route::get('/activity-note-check/{activity}', [ActivityController::class, 'checkNote'])->name('activity.check-note');

    Route::get('/search-user', [UserController::class, 'getUsers'])->name('search-user');
});
