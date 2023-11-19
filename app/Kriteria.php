<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    //
    protected $fillable = ['name', 'kode', 'level', 'parent_id', 'lembaga_id', 'jenjang_id'];
    public $timestamps = false;
    public $table = 'kriteria';

    public function children()
    {
        return $this->hasMany(Kriteria::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Kriteria::class, 'parent_id');
    }




    public function getNestedStructure()
    {
        $nestedStructure = $this->attributes;
        $nestedStructure['children'] =  $this->getChildrenStructure($this->kode);
        return $nestedStructure;
    }

    protected function getChildrenStructure($kode)
    {
        $childrenStructure = [];

        foreach ($this->children as $child) {
            $childrenStructure[] = [
                'id' => $child->id,
                'full_kode' => $kode . '.' . $child->kode,
                'name' => $child->name,
                'kode' => $child->kode,
                'level' => $child->level,
                'children' => $child->getChildrenStructure($kode . '.' . $child->kode),
            ];
        }
        return $childrenStructure;
    }

    protected function getParentStructure()
    {
        if (empty($this->parent))
            return null;
        else if ($this->parent->level == 1) {
            return $this->parent;
        } else {
            return [
                'id' => $this->parent->id,
                'name' => $this->parent->name,
                'kode' => $this->parent->kode,
                'level' => $this->parent->level,
                'parent_id' => $this->parent->parent_id,
                'parent' => $this->parent->getParentStructure(),
            ];
        };
    }

    public function scopeGetWithParent($query, $id)
    {
        $data = [];
        $data = $query->where('id', $id)->get()->first();
        $data['parent'] = $data->getParentStructure();
        $data = $data->toArray();
        $data['full_kode'] = $this->susunKodeParent($data);
        // dd($data);
        $text_parent = '';
        if (!empty($data['parent']['parent']['parent'])) {
            $data['parent']['parent']['parent']['full_kode'] = $this->susunKodeParent($data['parent']['parent']['parent']);
            $text_parent = $text_parent . $data['parent']['parent']['parent']['full_kode'] . ' ' . $data['parent']['parent']['parent']['name'] . "\n";
        }
        if (!empty($data['parent']['parent'])) {
            $data['parent']['parent']['full_kode'] = $this->susunKodeParent($data['parent']['parent']);
            $text_parent = $text_parent . $data['parent']['parent']['full_kode'] . ' ' . $data['parent']['parent']['name'] . "\n";
        }
        if (!empty($data['parent'])) {
            $data['parent']['full_kode'] = $this->susunKodeParent($data['parent']);
            $text_parent = $text_parent . $data['parent']['full_kode'] . ' ' . $data['parent']['name'] . "\n";
        }
        $data['val_cur_parent'] = $text_parent;

        $text_parent = $text_parent . $data['full_kode']  . ' ' . $data['name'];

        // echo ($text_parent);
        // die();
        $data['val_parent'] = $text_parent;

        return $data;
    }

    function susunKodeParent($data)
    {
        return (!empty($data['parent']['parent']['parent']['kode']) ? $data['parent']['parent']['parent']['kode'] . '.' : '') .
            (!empty($data['parent']['parent']['kode']) ? $data['parent']['parent']['kode'] . '.' : '') .
            (!empty($data['parent']['kode']) ? $data['parent']['kode'] . '.' : '') .
            $data['kode'] . '. ';
    }

    public function scopeGetChild($query, $filter = [])
    {
        $data = [];
        $query->selectRaw('kriteria.*, lembaga.name as nama_lembaga')
            ->join('lembaga', 'lembaga.id', '=', 'kriteria.lembaga_id')
            ->where('level', 1);

        if (!empty($filter['lembaga_id']))
            $query->where('lembaga_id', $filter['lembaga_id']);
        if (!empty($filter['jenjang_id']))
            $query->where('jenjang_id', $filter['jenjang_id']);

        $lv1 = $query->whereNotNull('lembaga_id')->orderBy('kode', 'ASC')
            ->get();
        foreach ($lv1 as $d) {
            $data[] = $d->getNestedStructure();
        }
        return $data;
    }
}
