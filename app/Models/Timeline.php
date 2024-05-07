<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $fillable = ['user_id', 'year', 'metode', 'category', 'start', 'end'];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
