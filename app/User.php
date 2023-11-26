<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
  use Notifiable, HasFactory, HasRoles;

  protected $fillable = ['name', 'email'];
  protected $hidden = [
    'password', 'remember_token',
  ];
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function getRoleNamesAttribute()
  {
    return $this->roles->pluck('name')->toArray();
  }

  public function studyProgram()
  {
    return $this->belongsTo(StudyProgram::class);
  }
  public function getStudyProgramNameAttribute()
  {
    return $this->studyProgram ? $this->studyProgram->name : null;
  }
}
