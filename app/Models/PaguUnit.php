<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaguUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'pagu_lembaga_id',
        'work_unit_id',
        'nominal',
    ];
    public function workUnit()
    {
        return $this->belongsTo(WorkUnit::class);
    }
    public function scopeUnitYear($query, $year, $work_unit)
    {
        return    $query->select(
            'pagu_units.*',
            'pagu_lembagas.year',
            'pagu_lembagas.nominal as pagu_ins',
            'pagu_units.nominal as pagu'
        )
            ->leftJoin('work_units', 'work_units.id', 'pagu_units.work_unit_id')
            ->leftJoin('pagu_lembagas', 'pagu_lembagas.id', 'pagu_lembaga_id')
            ->where('pagu_lembagas.year', $year)
            ->where('pagu_units.work_unit_id', $work_unit);
    }
}
