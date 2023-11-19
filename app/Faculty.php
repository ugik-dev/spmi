<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $guarded = ['name'];

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }
}
