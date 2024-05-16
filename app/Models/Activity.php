<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'performance_indicator_id', 'work_unit_id', 'dipa_id'];

    public function budgetImplementations()
    {
        return $this->hasMany(BudgetImplementation::class);
    }

    public function withdrawalPlans()
    {
        return $this->hasMany(WithdrawalPlan::class);
    }

    public function activityNote()
    {
        return $this->hasMany(ActivityNote::class);
    }

    public function bi()
    {
        return $this->hasMany(BudgetImplementation::class)->with(['accountCode', 'details2']);
    }
    public function bis()
    {
        return $this->hasMany(BudgetImplementation::class);
    }
    public function performanceIndicator()
    {
        return $this->belongsTo(PerformanceIndicator::class);
    }
    public function dipa()
    {
        return $this->belongsTo(Dipa::class);
    }

    /**
     * Calculate the total sum of a specific field in BudgetImplementation.
     *
     * @return float
     */
    public function calculateTotalSum()
    {
        return $this->budgetImplementations->sum(function ($budgetImplementation) {
            return $budgetImplementation->details->sum('total');
        });
    }

    public function akumulasiRPD()
    {
        return $this->withdrawalPlans->sum('amount_withdrawn');
    }

    /**
     * Calculate the total sum of a specific field in BudgetImplementation and return it in IDR format.
     *
     * @return string
     */
    public function calculateTotalSumFormatted()
    {
        $totalSum = $this->calculateTotalSum();

        return 'Rp ' . number_format($totalSum, 0, ',', '.');
    }

    public function activityRecap()
    {
        return $this->hasOne(ActivityRecap::class);
    }

    /**
     * Scope a query to sort activities by code in a case-sensitive manner.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortedByCode($query)
    {
        return $query->orderBy('code');
    }
    public function scopeActive($query, $dipa)
    {
        // return $query->select('activities.*')->join('budget_implementations', 'budget_implementations.activity_id', 'activities.id')->where('budget_implementations.dipa_id', $dipa->id)
        //     ->groupBy('activities.id');
    }
}
