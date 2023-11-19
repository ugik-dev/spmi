<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'role', 'prodi_kode', 'password',
    ];
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
}
