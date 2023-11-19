<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $guarded = ['name', 'code'];

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }
}
