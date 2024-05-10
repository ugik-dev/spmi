<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkUnit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'ppk', 'kepala'];

    public function unitBudgets()
    {
        return $this->hasMany(UnitBudget::class);
    }

    public function paguUnit()
    {
        return $this->hasMany(PaguUnit::class);
    }

    public function ppkUnit()
    {
        return $this->belongsTo(User::class, 'ppk', 'id');
    }
    public function kepalaUnit()
    {
        return $this->belongsTo(User::class, 'kepala', 'id');
    }
}
