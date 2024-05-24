<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function receiptItems()
    {
        return $this->hasMany(ReceiptItem::class, 'bi_detail', 'id');
    }

    public function scopeCountTotal($query, $dipa)
    {
        // dd($query
        //     ->join('budget_implementations as bi', 'bi.id', '=', 'budget_implementation_details.budget_implementation_id')
        //     ->where('bi.dipa_id', $dipa)->get()->toArray());

        return  $query
            ->join('budget_implementations as bi', 'bi.id', '=', 'budget_implementation_details.budget_implementation_id')
            ->where('bi.dipa_id', $dipa)->sum('total');
    }

    public function scopeCounter($query, $dipa, $year)
    {
        // dd($dipa);
        $query = DB::table('budget_implementation_details as bid')
            ->selectRaw('sum(ri.amount) as amount, YEAR(r.activity_date) as cur_year, MONTH(r.activity_date) as cur_month')
            ->join('receipt_items as ri', 'ri.bi_detail', '=', 'bid.id')
            ->join('receipts as r', 'r.id', '=', 'ri.receipt_id')
            ->where('bid.id', $dipa)
            ->groupBy(DB::raw('YEAR(r.activity_date), MONTH(r.activity_date)'))
            ->get();
        $res = [];
        foreach ($query as $r) {
            $res[$r->cur_month] = $r;
        }
        return $res;
        // dd($res);
        // dd($query->toArray());
    }
}
