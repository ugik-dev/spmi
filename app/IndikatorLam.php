<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndikatorLam extends Model
{
    public $fillable = ['id', 'dec', 'jenjang_id', 'l1_id', 'l2_id', 'l3_id', 'l4_id', 'bobot'];
    public $timestamps = false;
    public $table = 'indikators_lam';

    public function l1()
    {
        return $this->belongsTo(Kriteria::class, 'l1_id', 'id');
    }

    public function l2()
    {
        return $this->belongsTo(Kriteria::class, 'l2_id', 'id');
    }

    public function l3()
    {
        return $this->belongsTo(Kriteria::class, 'l3_id', 'id');
    }

    public function l4()
    {
        return $this->belongsTo(Kriteria::class, 'l4_id', 'id');
    }

    public function elements_parent()
    {
        return $this->hasMany(ElementParent::class);
    }
}
