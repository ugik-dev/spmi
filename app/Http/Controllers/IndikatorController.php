<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Degree;
use App\Indikator;
use App\Institution;
use App\Kriteria;
use App\Periode;

class IndikatorController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->input('institution'))) $filter['institution_id'] = 1;
        else  $filter['institution_id'] = $request->input('institution');
        if (empty($request->input('degree'))) $filter['degree_id'] = 1;
        else  $filter['degree_id'] = $request->input('degree');
        $j = Degree::where('id', $filter['degree_id'])->first();
        $l = Institution::get();
        $periode = Periode::get();
        $degrees = Degree::get();
        $indikator = Indikator::with(['l1', 'l2', 'l3', 'l4'])
            ->selectRaw('indikators.*')
            ->join('kriteria', 'kriteria.id', '=', 'indikators.l1_id')
            ->where('kriteria.degree_id', $filter['degree_id'])
            ->where('kriteria.institution_id', $filter['institution_id'])
            ->orderBy('id', 'ASC')->get();

        return view('indikator.index', [
            'd' => $indikator,
            'j' => $j,
            'degrees' => $degrees,
            'institution' => $l,
            'periode' => $periode,
            'filter' => $filter,
        ]);
    }

    public function create(Request $request)
    {
        $url = $request->url;

        $request->validate([
            'dec' => 'required',
        ]);

        Indikator::create([
            'dec' => $request->dec,
            // 'jenjang_id' => $request->jenjang,
            'l1_id' => $request->l1_id,
            'l2_id' => $request->l2_id,
            'l3_id' => $request->l3_id,
            'l4_id' => $request->l4_id,
            'bobot' => $request->bobot,
        ]);

        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Ditambahkan</strong>
    </div>');
        return redirect()->back();
        // return redirect()->to($url);
    }

    public function edit($id, Request $request)
    {
        $indikator = Indikator::with(['l1', 'l2', 'l3', 'l4'])
            ->selectRaw('indikators.*, kriteria.institution_id, kriteria.degree_id')
            ->join('kriteria', 'kriteria.id', '=', 'indikators.l1_id')
            ->find($id);
        // dd($indikator);
        // $jenjang = Jenjang::where('id', $indikator->jenjang_id)->first();
        $indikator->update([
            'dec' => $request->dec,
            'l1_id' => $request->l1_id,
            'l2_id' => $request->l2_id,
            'l3_id' => $request->l3_id,
            'l4_id' => $request->l4_id,
            'bobot' => floatval($request->bobot),
        ]);
        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Diedit</strong>
    </div>');
        return redirect()->to('indikator?institution=' . $indikator->institution_id . '&degree=' . $indikator->degree_id);
    }


    public function form_edit($id)
    {
        $url_from = back();
        $indikator = Indikator::with(['l1', 'l2', 'l3', 'l4'])
            ->selectRaw('indikators.*, kriteria.degree_id, kriteria.institution_id')
            ->join('kriteria', 'kriteria.id', '=', 'indikators.l1_id')
            ->find($id);
        // dd($indikator);
        return view('indikator.form_edit', [
            'i' => $indikator,
        ]);
    }
}
