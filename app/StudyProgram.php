<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
  protected $fillable = ['name', 'code', 'degree_id', 'faculty_id', 'vision', 'mission', 'description'];

  protected $casts = [
    'vision' => 'array',
  ];

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
  public function getDegreeNameAttribute()
  {
    return $this->degree ? $this->degree->name : null;
  }
  public function getFacultyNameAttribute()
  {
    return $this->faculty ? $this->faculty->name : null;
  }
}
