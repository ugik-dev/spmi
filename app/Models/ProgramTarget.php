<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramTarget extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'renstra_indicator_id'];

    public function performanceIndicators()
    {
        return $this->hasMany(PerformanceIndicator::class);
    }
    public function indikatorPerkinDipa()
    {
        return $this->hasMany(PerformanceIndicator::class);
    }

    public function iku()
    {
        return $this->belongsTo(RenstraIndicator::class, 'renstra_indicator_id');
    }
}
