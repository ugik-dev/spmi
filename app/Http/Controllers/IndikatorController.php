<?php

namespace App\Http\Controllers;

use App\Indikator;
use App\IndikatorLam;
use App\Jenjang;
use App\Score;
use App\Lembaga;
use App\Periode;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{
    public function index(Request $request, $jenjang)
    {
        $j = Jenjang::where('kode', $jenjang)->first();
        $indikator = Indikator::with(['l1', 'l2', 'l3', 'l4'])->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get();
        return view('indikator.index', [
            'd' => $indikator,
            'j' => $j,
        ]);
    }

    public function index_lam(Request $request)
    {
        if (empty($request->input('lembaga'))) $filter['lembaga_id'] = 1;
        else  $filter['lembaga_id'] = $request->input('lembaga');

        if (empty($request->input('jenjang'))) $filter['jenjang_id'] = 1;
        else  $filter['jenjang_id'] = $request->input('jenjang');

        $j = Jenjang::where('id', $filter['jenjang_id'])->first();
        $l = Lembaga::get();
        $periode = Periode::get();
        $jenjang = Jenjang::get();
        // dd($filter);
        $indikator = IndikatorLam::with(['l1', 'l2', 'l3', 'l4'])
            ->selectRaw('indikators_lam.*')
            ->join('kriteria', 'kriteria.id', '=', 'indikators_lam.l1_id')
            ->where('kriteria.jenjang_id', $filter['jenjang_id'])
            ->where('kriteria.lembaga_id', $filter['lembaga_id'])
            ->orderBy('id', 'ASC')->get();

        return view('indikator.index_lam', [
            'd' => $indikator,
            'j' => $j,
            'jenjang' => $jenjang,
            'lembaga' => $l,
            'periode' => $periode,
            'filter' => $filter,
        ]);
    }

    public function store(Request $request)
    {
        $url = $request->url;

        $request->validate([
            'dec' => 'required',
        ]);

        IndikatorLam::create([
            'dec' => $request->dec,
            'jenjang_id' => $request->jenjang,
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

    public function konfirmasi(Indikator $indikator)
    {
        return view('indikator.konfirmasi', [
            'i' => $indikator,
            'j' => Jenjang::where('id', $indikator->jenjang_id)->first(),
        ]);
    }

    public function hapusIndikator(Indikator $indikator)
    {
        $jenjang = Jenjang::where('id', $indikator->jenjang_id)->first();
        Score::where('indikator_id', $indikator->id)->delete();
        $indikator->delete();

        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Dihapus</strong>
    </div>');
        return redirect()->route('indikator-' . $jenjang->kode);
    }

    public function editFormIndikator($id)
    {
        $url_from = back();
        // dd();
        // $indikator = IndikatorLam::with(['l1', 'l2', 'l3', 'l4'])->find($id);
        // dd($indikator);
        $indikator = IndikatorLam::with(['l1', 'l2', 'l3', 'l4'])
            ->selectRaw('indikators_lam.*, kriteria.lembaga_id, kriteria.jenjang_id')
            ->join('kriteria', 'kriteria.id', '=', 'indikators_lam.l1_id')
            ->find($id);

        return view('indikator.editIndikator', [
            'i' => $indikator,
            // 'j' => Jenjang::where('id', $indikator->jenjang_id)->first(),
        ]);
    }

    public function putIndikator($id, Request $request)
    {
        $indikator = IndikatorLam::with(['l1', 'l2', 'l3', 'l4'])
            ->selectRaw('indikators_lam.*, kriteria.lembaga_id, kriteria.jenjang_id')
            ->join('kriteria', 'kriteria.id', '=', 'indikators_lam.l1_id')
            ->find($id);
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
        return redirect()->to('indikator-lam?lembaga=' . $indikator->lembaga_id . '&jenjang=' . $indikator->jenjang_id);
    }

    public function inputScore(Indikator $indikator)
    {
        return view('indikator.input-score', [
            'indikator' => $indikator,
        ]);
    }

    public function storeScore(Request $request)
    {
        $ind = Indikator::where('id', $request->indikator_id)->first();
        $jenjang = Jenjang::where('id', $ind->jenjang_id)->first();

        $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        Score::create([
            'name' => $request->name,
            'value' => floatval($request->value),
            'indikator_id' => $request->indikator_id,
        ]);

        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Ditambahkan</strong>
    </div>');
        return redirect()->route('indikator-jenjang', $jenjang->kode);
    }

    public function cekScore(Indikator $indikator)
    {
        $att = Score::where('indikator_id', $indikator->id)->get();
        return view('indikator.cek-score', [
            's' => $att,
        ]);
    }

    public function konfirmasiScore(Score $score)
    {
        $i = Indikator::where('id', $score->indikator_id)->first();
        $jenjang = Jenjang::where('id', $i->jenjang_id)->first();

        return view('indikator.konfirmasiScore', [
            's' => $score,
            'j' => $jenjang,
        ]);
    }

    public function hapusScore(Score $score)
    {
        $i = Indikator::where('id', $score->indikator_id)->first();
        $jenjang = Jenjang::where('id', $i->jenjang_id)->first();
        $score->delete();
        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Dihapus</strong>
    </div>');
        return redirect()->route('indikator-' . $jenjang->kode);
    }

    public function editScore(Score $score)
    {

        return view('indikator.editScore', [
            's' => $score,
            'i' => Indikator::where('id', $score->indikator_id)->first(),
        ]);
    }

    public function putScore(Score $score, Request $request)
    {
        $i = Indikator::where('id', $score->indikator_id)->first();
        $score->update([
            'name' => $request->name,
            'value' => $request->value,
        ]);
        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Diedit</strong>
    </div>');
        return redirect()->to('/indikator/cek-score/' . $i->id);
    }
}
