<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DipaLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'dipa_id',
        'user_id',
        'description',
        'label'
    ];
}
