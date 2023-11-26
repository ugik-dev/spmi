<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $fillable = ['study_program_id', 'periode_id', 'l1_id', 'l2_id', 'l3_id', 'l4_id', 'bobot', 'indikator_id', 'score_berkas', 'score_hitung', 'count_berkas', 'min_akreditasi', 'status_akreditasi', 'min_unggul', 'status_unggul', 'min_baik', 'status_baik', 'ket_auditor', 'deskripsi', 'score_auditor'];
    public $timestamps = false;

    public function l1()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function l2()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function l3()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function l4()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class);
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class);
    }
}
