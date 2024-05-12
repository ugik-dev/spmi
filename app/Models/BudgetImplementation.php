<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BudgetImplementation extends Model
{
    use HasFactory;

    protected $fillable = ['activity_id', 'account_code_id', 'dipa_id'];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function activityReview()
    {
        // return $this->belongsTo(Activity::class, 'activity_id')->with('withdrawalPlans');
    }

    public function accountCode()
    {
        return $this->belongsTo(AccountCode::class);
    }

    public function details()
    {
        return $this->hasMany(BudgetImplementationDetail::class);
    }
    public function details2()
    {
        return $this->hasMany(BudgetImplementationDetail::class)->with('expenditureUnit');
    }

    /**
     * Scope a query to group data by activity code.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroupByActivityCode($query)
    {
        return $query->join('activities', 'activities.id', '=', 'budget_implementations.activity_id')
            ->groupBy('activities.code');
    }

    /**
     * Scope a query to group data by account code.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroupByAccountCode($query)
    {
        return $query->join('account_codes', 'account_codes.id', '=', 'budget_implementations.account_code_id')
            ->groupBy('account_codes.code');
    }

    /**
     * Calculate the total sum of 'total' from details for this budget implementation.
     */
    public function calculateDetailsTotalSum()
    {
        return $this->details->sum('total');
    }

    /**
     * Static function to get grouped data with total sums.
     */
    public static function getGroupedDataWithTotals($dipa_id, $rpd = false)
    {
        $budgetImplementations = self::with(['activity', 'accountCode', 'details'])->where('dipa_id', $dipa_id)
            ->get();
        return $budgetImplementations
            ->groupBy('activity.code')
            ->sortKeysUsing(function ($key1, $key2) {
                return strtolower($key1) <=> strtolower($key2); // Case-insensitive sorting
            })
            ->map(function ($activityGroup) {
                $activityTotalSum = $activityGroup->reduce(function ($carry, $budgetImplementation) {
                    return $carry + $budgetImplementation->calculateDetailsTotalSum();
                }, 0);

                $accountGroups = $activityGroup->groupBy('accountCode.code')->map(function ($accountGroup) {
                    $accountTotalSum = $accountGroup->reduce(function ($carry, $budgetImplementation) {
                        return $carry + $budgetImplementation->calculateDetailsTotalSum();
                    }, 0);

                    if ($accountGroup->isNotEmpty()) {
                        $accountGroup->first()->account_total_sum = $accountTotalSum;
                    }

                    return $accountGroup;
                });

                if ($activityGroup->isNotEmpty()) {
                    $activityGroup->first()->activity_total_sum = $activityTotalSum;
                }

                return $accountGroups;
            });
    }

    public static function getGroupedDataWithTotalsRpd($dipa_id, $rpd = false)
    {
        $budgetImplementations = self::with(['activity', 'accountCode', 'details'])->where('dipa_id', $dipa_id)
            ->get();
        // dd($budgetImplementations[0]->activity->withdrawalPlans);
        $res =  $budgetImplementations
            ->groupBy('activity.code')
            ->sortKeysUsing(function ($key1, $key2) {
                return strtolower($key1) <=> strtolower($key2); // Case-insensitive sorting
            })
            ->map(function ($activityGroup) {
                $activityTotalSum = $activityGroup->reduce(function ($carry, $budgetImplementation) {
                    return $carry + $budgetImplementation->calculateDetailsTotalSum();
                }, 0);

                $accountGroups = $activityGroup->groupBy('accountCode.code')->map(function ($accountGroup) {
                    $accountTotalSum = $accountGroup->reduce(function ($carry, $budgetImplementation) {
                        return $carry + $budgetImplementation->calculateDetailsTotalSum();
                    }, 0);

                    if ($accountGroup->isNotEmpty()) {
                        $accountGroup->first()->account_total_sum = $accountTotalSum;
                    }

                    return $accountGroup;
                });

                if ($activityGroup->isNotEmpty()) {
                    $activityGroup->first()->activity_total_sum = $activityTotalSum;
                }

                return $accountGroups;
            });
        return $res;
        // foreach ($res as $r) {
        //     dd($r->);
        // }
        // dd($res);
    }
}
