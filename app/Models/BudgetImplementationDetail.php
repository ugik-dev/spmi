<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetImplementationDetail extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'volume', 'price', 'total', 'expenditure_unit_id', 'budget_implementation_id'];

    public function expenditureUnit()
    {
        return $this->belongsTo(ExpenditureUnit::class);
    }

    public function budgetImplementation()
    {
        return $this->belongsTo(BudgetImplementation::class);
    }

    public function scopeCountTotal($query, $dipa)
    {
        return  $query
            ->join('budget_implementations as bi', 'bi.id', '=', 'budget_implementation_details.budget_implementation_id')
            ->where('bi.dipa_id', $dipa)->sum('total');
    }
}
