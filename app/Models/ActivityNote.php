<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityNote extends Model
{
    use HasFactory;

    protected $fillable = ['activity_id', 'user_id', 'description',];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email');
    }
}
