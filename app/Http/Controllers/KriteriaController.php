<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Degree;
use App\Faculty;
use App\Institution;
use App\Kriteria;
use Facade\FlareClient\Http\Response;

class KriteriaController extends Controller
{
    public function index(Request $req)
    {
        if (empty($req->input('institutions'))) $filter['institution_id'] = 1;
        else  $filter['institution_id'] = $req->input('institutions');

        if (empty($req->input('degrees'))) $filter['degree_id'] = 1;
        else  $filter['degree_id'] = $req->input('degrees');

        $j = Degree::where('code', '<>', 'NULL')->get();
        $r = Kriteria::GetChild($filter);
        $l = Institution::get();
        $dataContent =  [
            'degrees' => $j,
            'r' => $r,
            'institutions' => $l,
            'filter' => $filter,
        ];

        // dd($r);
        return view('kriteria.index', $dataContent);
    }

    public function search(Request $request)
    {
        try {
            $data = Kriteria::GetWithParent($request->input('id'));
            return response()->customJson(false, 'Success', $data);
        } catch (Exception $ex) {
            return response()->customJson(true, $ex->getMessage(), null);
        }
    }

    public function search_select(Request $request)
    {


        if (empty($request->parent))
            $data = Kriteria::where('degree_id', $request->degree_id)
                ->where('institution_id', $request->institution_id)->where('level', 1)->get();
        else {
            $data = Kriteria::where('kriteria_id', $request->parent)->get();
        }
        // dd($data);
        if (!empty($data))
            echo "<option value=''> -- Pilih Kriteria --</option>";
        foreach ($data as $i) {
            echo "<option value='" . $i->id . "'>" . $i->code . '. ' . $i->name . "</option>";
        }
    }

    public function create(Request $request)
    {
        try {
            if ($request->lv == 1) {
                $data = Kriteria::create([
                    'code' => $request->code,
                    'name' => $request->name,
                    'degree_id' => $request->degree_id,
                    'level' => 1,
                    'institution_id' => $request->institution_id,
                ]);
            } else {
                $data = Kriteria::create([
                    'code' => $request->code,
                    'name' => $request->name,
                    'level' => $request->lv,
                    'kriteria_id' => $request->kriteria_id,
                ]);
            }
            return response()->customJson(false, 'Success', $data);
        } catch (Exception $ex) {
            return response()->customJson(true, $ex->getMessage(), null);
        }
    }

    public function edit(Request $request)
    {
        try {
            $data = [
                'code' => $request->code,
                'name' => $request->name,
            ];
            $data = Kriteria::where('id', $request->id)->update($data);
            return response()->customJson(false, 'Success', $data);
        } catch (Exception $ex) {
            return response()->customJson(true, $ex->getMessage(), null);
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = Kriteria::where('id', $request->id)->delete();
            return response()->customJson(false, 'Success', $data);
        } catch (Exception $ex) {
            return response()->customJson(true, $ex->getMessage(), null);
        }
    }
}
