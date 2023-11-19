<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    protected $guarded = ['name', 'code'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
