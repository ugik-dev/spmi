<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'receipt_id', 'rd_id', 'bi_detail', 'rinc', 'desc', 'amount'
    ];

    public function scopeGroupByDetail($query, $receipt)
    {
        $details = $query->selectRaw('bi_detail, sum(amount) as amount_total')->with('bi')
            ->where('receipt_id', '=', $receipt)->groupBy('bi_detail')->get();
        foreach ($details as $key => $detail) {
            $digunakan = $query = $this->selectRaw('bi_detail, sum(amount) as digunakan')
                // ->where('receipt_id', '<>', $receipt)
                ->where('bi_detail', '=', $detail->bi_detail)
                ->groupBy('bi_detail')
                ->first();
            $details[$key]->pagu =   $detail->bi->total ?? 0;
            $details[$key]->digunakan =  ($digunakan->digunakan ?? 0);
            $details[$key]->sisa = (int) (($detail->bi->total ?? 0) - ($digunakan->digunakan ?? 0));
        }
        // dd($details);
        return $details;
        // dd($res);

        // if ($tmp) {
        //     $splitReference = explode('/', $tmp->reference_number)[0];
        //     $newNumber = str_pad($splitReference + 1, 3, '0', STR_PAD_LEFT);
        //     $number =  $newNumber . '/' . $number;
        // } else {
        //     $number = '001/' . $number;
        // }

        // $receipt->reference_number = $number;
        // $receipt->save();
    }

    public function user()
    {

        return $this->belongsTo(User::class)->with('employee');
    }
    public function bi()
    {
        return $this->belongsTo(BudgetImplementationDetail::class, 'bi_detail', 'id');
    }
}
