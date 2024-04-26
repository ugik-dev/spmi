<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DipaLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'dipa_id',
        'user_id',
        'description',
        'label'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
