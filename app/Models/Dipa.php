<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dipa extends Model
{
    use HasFactory;
    protected $fillable = [
        'year',
        'status',
        'revision',
        'work_unit_id'
    ];

    public function bi()
    {
        return $this->hasMany(BudgetImplementation::class, 'dipa_id')->with(['activity', 'accountCode', 'details']);
    }
}
