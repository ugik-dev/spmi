<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IKSK extends Model
{
    use HasFactory;
    protected $table = "iksks";

    protected $fillable = ['name', 'value', 'performance_indicator_id'];

    public function getValueAsPercentageAttribute()
    {
        return $this->value * 100 . '%';
    }

    // public function setValueAttribute($value)
    // {
    //     $this->attributes['value'] = $value / 100;
    // }

    public function scopeAboveValue($query, $minValue)
    {
        return $query->where('value', '>', $minValue);
    }

    public function performanceIndicators()
    {
        return $this->belongsTo(PerformanceIndicator::class, 'performance_indicator_id', 'id');
    }
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function activityDipa()
    {
        return $this->hasMany(Activity::class);
    }

    public function isAboveThreshold($threshold)
    {
        return $this->value > $threshold;
    }
}
