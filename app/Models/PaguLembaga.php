<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaguLembaga extends Model
{
    use HasFactory;
    protected $fillable = [
        'year',
        'nominal',
    ];

    public function paguUnit()
    {
        return $this->hasMany(PaguUnit::class);
    }

    public static function test($dipa_id = false, $rpd = false)
    {
        return  self::with('paguUnit')->get();
    }
}
