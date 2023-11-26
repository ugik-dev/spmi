<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $fillable = ['name', 'periode_start', 'periode_end', 'prodi_start', 'prodi_end', 'auditor_start', 'auditor_end', 'revisi_start', 'revisi_end'];
}
