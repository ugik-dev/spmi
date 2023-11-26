<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    //
    protected $fillable = ['name', 'code', 'level', 'kriteria_id', 'institution_id', 'degree_id'];
    public $timestamps = false;
    public $table = 'kriteria';

    public function children()
    {
        return $this->hasMany(Kriteria::class, 'kriteria_id');
    }

    public function parent()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }




    public function getNestedStructure()
    {
        $nestedStructure = $this->attributes;
        $nestedStructure['children'] =  $this->getChildrenStructure($this->code);
        return $nestedStructure;
    }

    protected function getChildrenStructure($code)
    {
        $childrenStructure = [];

        foreach ($this->children as $child) {
            $childrenStructure[] = [
                'id' => $child->id,
                'full_code' => $code . '.' . $child->code,
                'name' => $child->name,
                'code' => $child->code,
                'level' => $child->level,
                'children' => $child->getChildrenStructure($code . '.' . $child->code),
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
                'code' => $this->parent->code,
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
        $data['full_code'] = $this->susuncodeParent($data);
        // dd($data);
        $text_parent = '';
        if (!empty($data['parent']['parent']['parent'])) {
            $data['parent']['parent']['parent']['full_code'] = $this->susuncodeParent($data['parent']['parent']['parent']);
            $text_parent = $text_parent . $data['parent']['parent']['parent']['full_code'] . ' ' . $data['parent']['parent']['parent']['name'] . "\n";
        }
        if (!empty($data['parent']['parent'])) {
            $data['parent']['parent']['full_code'] = $this->susuncodeParent($data['parent']['parent']);
            $text_parent = $text_parent . $data['parent']['parent']['full_code'] . ' ' . $data['parent']['parent']['name'] . "\n";
        }
        if (!empty($data['parent'])) {
            $data['parent']['full_code'] = $this->susuncodeParent($data['parent']);
            $text_parent = $text_parent . $data['parent']['full_code'] . ' ' . $data['parent']['name'] . "\n";
        }
        $data['val_cur_parent'] = $text_parent;

        $text_parent = $text_parent . $data['full_code']  . ' ' . $data['name'];

        $data['val_parent'] = $text_parent;

        return $data;
    }

    function susuncodeParent($data)
    {
        return (!empty($data['parent']['parent']['parent']['code']) ? $data['parent']['parent']['parent']['code'] . '.' : '') .
            (!empty($data['parent']['parent']['code']) ? $data['parent']['parent']['code'] . '.' : '') .
            (!empty($data['parent']['code']) ? $data['parent']['code'] . '.' : '') .
            $data['code'] . '. ';
    }

    public function scopeGetChild($query, $filter = [])
    {
        $data = [];
        $query->selectRaw('kriteria.*, institutions.name as nama_institutions')
            ->join('institutions', 'institutions.id', '=', 'kriteria.institution_id')
            ->where('level', 1);

        if (!empty($filter['institution_id']))
            $query->where('institution_id', $filter['institution_id']);
        if (!empty($filter['degree_id']))
            $query->where('degree_id', $filter['degree_id']);

        $lv1 = $query->whereNotNull('institution_id')->orderBy('code', 'ASC')
            ->get();
        foreach ($lv1 as $d) {
            $data[] = $d->getNestedStructure();
        }
        return $data;
    }
}
