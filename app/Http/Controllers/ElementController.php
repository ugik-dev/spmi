<?php

namespace App\Http\Controllers;

use App\Berkas;
use App\Element;
use App\ElementParent;
use App\IndikatorLam;
use App\Indikator;
use App\Jenjang;
use App\Prodi;
use App\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ElementController extends Controller
{
    public function index(Request $request, $prodi)
    {
        $p = Prodi::where('kode', $prodi)->first();
        // dd
        $element = Element::where('prodi_id', $p->id)->get();

        return view('element.index', [
            'p' => $p,
            'e' => $element,
            'count_element' => $element->count(),
            'count_berkas' => $element->sum("count_berkas"),
            'score_hitung' => $element->sum("score_hitung"),
        ]);
    }

    public function prodi(Request $request, $prodi)
    {
        $p = Prodi::where('kode', $prodi)->first();
        $element = Element::with(['l1', 'l2', 'l3', 'l4', 'indikator', 'berkas'])->where('prodi_id', $p->id)->get();

        return view('element.index_prodi', [
            'p' => $p,
            'element' => $element,
            'count_element' => $element->count(),
            'count_berkas' => $element->sum("count_berkas"),
            'score_hitung' => $element->sum("score_hitung"),
        ]);
    }

    function susunElement($element)
    {
        $arr = [];

        foreach ($element as $e) {
            if (!empty($e->l4_name))
                $e = $this->inspekKode($e->l4_name);
            else  if (!empty($e->l3_name))
                $e = $this->inspekKode($e->l3_name);
            else  if (!empty($e->l2_name))
                $e = $this->inspekKode($e->l2_name);
            else  if (!empty($e->l1_name))
                $e =  $this->inspekKode($e->l1_name);
            // return $e;

            // if (!empty($e[3])) {
            //     $arr[$e[0]][]
            //     // LV4
            // } else if (!empty($e[2])) {
            //     // LV 3
            // } else if (!empty($e[1])) {
            //     // LV 2
            // } else if (!empty($e[0])) {
            //     // LV 1
            // }
            // // dd($e);
        }

        return $arr;
    }

    function inspekKode($k)
    {
        $kode = explode(' ', $k);
        if (!empty($kode[0])) {

            $kode = explode('.', $kode[0]);
            return $kode;
        } else {
            echo "Kesalahan pada " . $k;
            die();
        }
    }
    public function listElement(Request $requestm, $jenjang)
    {
        $j = Jenjang::where('kode', $jenjang)->first();
        $element = Element::with(['l1', 'l2', 'l3', 'l4'])
            ->leftJoin('prodis', 'prodis.id', '=', 'elements.prodi_id')
            ->where('jenjang_id', $j->id)->get();
        // die();
        // dd($j);
        return view('element.index', [
            'j' => $j,
            'e' => $element,
            'count_element' => $element->count(),
        ]);
    }

    public function tambahElementParent(Request $req)
    {
        $filter = $req->toArray();
        return view(
            'element.tambah_parent',
            [
                'filter' => $filter
            ]
        );
    }


    public function tambahElement(Request $req)
    {
        $filter = [];
        if (!empty($req->prodi)) $filter['prodi'] = $req->prodi;
        if (!empty($req->prodi)) $filter['jenjang_id'] = $req->jenjang;
        // dd($filter);
        return view(
            'element.tambah',
            [
                'filter' => $filter
            ]
        );
    }

    public function sync(Request $request)
    {
        // dd($request->input());
        $prodi = Prodi::where('jenjang_id', $request->jenjang_id)
            ->where('lembaga_id', $request->lembaga_id)
            ->get();
        $indikator = IndikatorLam::selectRaw('indikators_lam.*')
            ->join('kriteria', 'kriteria.id', '=', 'indikators_lam.l1_id')
            ->where('kriteria.jenjang_id', $request->jenjang_id)
            ->where('kriteria.lembaga_id', $request->lembaga_id)
            ->orderBy('id', 'ASC')->get();
        $jenjang = Jenjang::where('id', $request->jenjang)->get()->first();
        // dd($indikator);
        // dd($prodi);
        $row = [];
        foreach ($indikator as $i) {
            foreach ($prodi as $p) {
                // $score_hitung = $i->bobot * Element->score_auditor;
                Element::updateOrCreate(
                    [
                        'prodi_id' => $p->id,
                        'l1_id' => $i->l1_id,
                        'l2_id' => $i->l2_id,
                        'l3_id' => $i->l3_id,
                        'l4_id' => $i->l4_id,
                        'indikator_id' => $i->id,
                        'periode_id' => $request->periode_id,
                    ],
                    [
                        'bobot' => $i->bobot,
                        // 'deskripsi' => '',
                        // 'score_berkas' => 0,
                        'score_hitung' => \DB::raw('IFNULL((score_auditor * ' . $i->bobot . '), 0)'),
                        // 'count_berkas' => 0
                    ]
                );
            }
        }

        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Element Berhasil Sinkron</strong>
                </div>');
        return redirect()->to('indikator-lam?lembaga=' . $request->lembaga_id . '&jenjang=' . $request->jenjang_id);

        // return redirect()->route('indikator-jenjang', $jenjang->kode);
    }

    public function store(Request $request)
    {

        $prodi = Prodi::where('jenjang_id', $request->jenjang_id)->get();
        $jenjang = Jenjang::where('id', $request->jenjang_id)->get()->first();
        $row = [];
        // $row = [
        //     'prodi_id' => $request->prodi_id,
        //     'l1_id' => $request->l1_id,
        //     'l2_id' => $request->l2_id,
        //     'l3_id' => $request->l3_id,
        //     'l4_id' => $request->l4_id,
        //     'score_berkas' => 0,
        //     'score_hitung' => 0,
        //     'count_berkas' => 0,
        //     'indikator_id' => $request->ind_id,
        // ];

        for ($i = 0; $i < count($request->bobot); $i++) {
            foreach ($prodi as $p) {
                $row[] = [
                    'prodi_id' => $p->id,
                    'l1_id' => $request->l1_id,
                    'l2_id' => $request->l2_id,
                    'l3_id' => $request->l3_id,
                    'l4_id' => $request->l4_id,
                    'bobot' => floatval($request->bobot[$i]),
                    'deskripsi' => $request->deskripsi[$i],
                    'score_berkas' => 0,
                    'score_hitung' => 0,
                    'count_berkas' => 0,
                    'indikator_id' => $request->ind_id,
                ];
            }
        }

        // if ($request->l1_id && $request->l2_id == null && $request->l3_id == null && $request->l4_id == null) {
        //     for ($i = 0; $i < count($request->l1_id); $i++) {
        //         $row[] = [
        //             'prodi_id' => $request->prodi_id,
        //             'l1_id' => $request->l1_id[$i],
        //             'bobot' => floatval($request->bobot),
        //             'score_berkas' => 0,
        //             'score_hitung' => 0,
        //             'count_berkas' => 0,
        //             'indikator_id' => $request->ind_id,
        //         ];
        //     }
        // } elseif ($request->l1_id && $request->l2_id && $request->l3_id == null && $request->l4_id == null) {
        //     for ($i = 0; $i < count($request->l1_id); $i++) {
        //         $row[] = [
        //             'prodi_id' => $request->prodi_id,
        //             'l1_id' => $request->l1_id[$i],
        //             'l2_id' => $request->l2_id[$i],
        //             'bobot' => floatval($request->bobot),
        //             'score_berkas' => 0,
        //             'score_hitung' => 0,
        //             'count_berkas' => 0,
        //             'indikator_id' => $request->ind_id,
        //         ];
        //     }
        // } elseif ($request->l1_id && $request->l2_id && $request->l3_id && $request->l4_id == null) {
        //     for ($i = 0; $i < count($request->l1_id); $i++) {
        //         $row[] = [
        //             'prodi_id' => $request->prodi_id,
        //             'l1_id' => $request->l1_id[$i],
        //             'l2_id' => $request->l2_id[$i],
        //             'l3_id' => $request->l3_id[$i],
        //             'bobot' => floatval($request->bobot),
        //             'score_berkas' => 0,
        //             'score_hitung' => 0,
        //             'count_berkas' => 0,
        //             'indikator_id' => $request->ind_id,
        //         ];
        //     }
        // } elseif ($request->l1_id && $request->l2_id && $request->l3_id && $request->l4_id) {
        //     for ($i = 0; $i < count($request->l1_id); $i++) {
        //         $row[] = [
        //             'prodi_id' => $request->prodi_id,
        //             'l1_id' => $request->l1_id[$i],
        //             'l2_id' => $request->l2_id[$i],
        //             'l3_id' => $request->l3_id[$i],
        //             'l4_id' => $request->l4_id[$i],
        //             'bobot' => floatval($request->bobot),
        //             'score_berkas' => 0,
        //             'score_hitung' => 0,
        //             'count_berkas' => 0,
        //             'indikator_id' => $request->ind_id,
        //         ];
        //     }
        // } else {
        //     echo "Ada Kesalahan pada Sistem";
        //     die;
        // }

        Element::insert($row);
        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Element Berhasil Dibuat</strong>
    </div>');
        return redirect()->route('element-list', $jenjang->kode);
    }

    public function storeparent(Request $request)
    {
        try {
            $kodeJenjang = Jenjang::findOrFail($request->jenjang_id);
            $kodeJenjang = $kodeJenjang->kode ? $kodeJenjang->kode : null;
            // $kodeJenjang = Jenjang::findOrFail($request->jenjang_id)?->kode;
            $row = [];
            for ($i = 0; $i < count($request->bobot); $i++) {
                $row[] = [
                    'jenjang_id' => $request->jenjang_id,
                    'bobot' => floatval($request->bobot[$i]),
                    'deskripsi' => $request->deskripsi[$i],
                    'indikator_id' => $request->ind_id,
                ];
            }

            ElementParent::insert($row);
            session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Element Berhasil Dibuat</strong>
    </div>');
            return redirect()->route('element-list', ['jenjang' => $kodeJenjang]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return redirect()->route('some.route')->with('error', 'Model not found.');
        }
    }

    public function unggahBerkas(Element $element)
    {
        return view('element.unggah-berkas', [
            'element' => $element,
            'score' => Score::where('indikator_id', $element->indikator_id)->get(),
            'indikator' => Indikator::where('id', $element->indikator_id)->with(['l1', 'l2', 'l3', 'l4'])->first(),
        ]);
    }

    public function storeBerkas(Request $request)
    {
        $id = $request->element_id;
        $element = Element::where('id', $id)->first();

        if ($request->file('file')) {
            $file = $request->file('file');
            $md5 = md5($file->getClientOriginalName());
            $ex = $file->getClientOriginalExtension();
            $namefile = $md5 . "." . $ex;

            Berkas::create([
                'element_id' => $element->id,
                'prodi_id' => $element->prodi_id,
                'l1_id' => $element->l1_id,
                'l2_id' => $element->l2_id,
                'l3_id' => $element->l3_id,
                'l4_id' => $element->l4_id,
                'file_name' => $request->file_name,
                'file' => $namefile,
                'dec' => $request->dec,
                'score' => floatval($request->score),
            ]);

            $file->move('document', $namefile);

            $berkaslama = $element->count_berkas;
            $count_berkas = $berkaslama + 1;

            $b = Berkas::where('element_id', $element->id)->get();
            $s = $b->sum("score");
            $avg = $s / $count_berkas;

            $element->update([
                'score_berkas' => $avg,
                'count_berkas' => $count_berkas,
            ]);

            $hasil_bobot = $element->score_berkas * $element->bobot;

            $element->update([
                'score_hitung' => $hasil_bobot,
            ]);
        } else {
            $element->update([
                'score_berkas' => floatval($request->score),
            ]);

            $scorexbobot = $element->score_berkas * $element->bobot;

            $element->update([
                'score_hitung' => $scorexbobot,
            ]);
        }

        if ($element->min_akreditasi > 0) {
            if ($element->score_hitung >= $element->min_akreditasi) {
                $element->update([
                    'status_akreditasi' => 'Y',
                ]);
            } else {
                $element->update([
                    'status_akreditasi' => 'N',
                ]);
            }
        }

        if ($element->min_unggul > 0) {
            if ($element->score_hitung >= $element->min_unggul) {
                $element->update([
                    'status_unggul' => 'Y',
                ]);
            } else {
                $element->update([
                    'status_unggul' => 'N',
                ]);
            }
        }

        if ($element->min_baik > 0) {
            if ($element->score_hitung >= $element->min_baik) {
                $element->update([
                    'status_baik' => 'Y',
                ]);
            } else {
                $element->update([
                    'status_baik' => 'N',
                ]);
            }
        }

        $prodi = Prodi::where('id', $element->prodi_id)->first();

        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Berkas berhasil di simpan</strong>
    </div>');
        return redirect()->route('lihat-berkas', $element->id);
    }

    public function lihatBerkas(Element $element)
    {
        $berkas = Berkas::where('element_id', $element->id)->get();
        $prodi = Prodi::where('id', $element->prodi_id)->get()->first();
        if ($berkas->count() > 1) {
            $avg = round($berkas->sum('score') / $berkas->count(), 2);
        } else {
            $avg = $element->score_berkas;
        }

        return view('element.lihat-berkas', [
            'element' => $element,
            'berkas' => $berkas,
            'prodi' => $prodi,
            'avg' => $avg,
        ]);
    }

    public function akreditas(Element $element)
    {
        return view('element.akreditas', [
            'element' => $element,
        ]);
    }

    public function putAkreditas(Element $element, Request $request)
    {

        $prodi = Prodi::where('id', $element->prodi_id)->first();
        if ($request->score >= floatval($request->min)) {
            $keputusan = "Y";
            $pesan = '<div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Menurut ketentuan nilai sudah mencukupi untuk Terakreditasi</strong>
        </div>';
        } else {
            $keputusan = "N";
            $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Menurut ketentuan nilai belum mencukupi untuk Terakreditasi</strong>
        </div>';
        }

        $element->update([
            'min_akreditasi' => floatval($request->min),
            'status_akreditasi' => $keputusan,
        ]);

        session()->flash('pesan', $pesan);
        return redirect()->route('element-prodi', $prodi->kode);
    }

    public function unggul(Element $element)
    {
        return view('element.unggul', [
            'element' => $element,
        ]);
    }

    public function putUnggul(Element $element, Request $request)
    {

        $prodi = Prodi::where('id', $element->prodi_id)->first();
        if ($request->score >= floatval($request->min)) {
            $keputusan = "Y";
            $pesan = '<div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Menurut ketentuan nilai sudah mencukupi untuk Peringkat Unggul</strong>
        </div>';
        } else {
            $keputusan = "N";
            $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Menurut ketentuan nilai belum mencukupi untuk Peringkat Unggul</strong>
        </div>';
        }

        $element->update([
            'min_unggul' => floatval($request->min),
            'status_unggul' => $keputusan,
        ]);

        session()->flash('pesan', $pesan);
        return redirect()->route('element-prodi', $prodi->kode);
    }

    public function baik(Element $element)
    {
        return view('element.baik', [
            'element' => $element,
        ]);
    }

    public function putBaik(Element $element, Request $request)
    {

        $prodi = Prodi::where('id', $element->prodi_id)->first();
        if ($request->score >= floatval($request->min)) {
            $keputusan = "Y";
            $pesan = '<div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Menurut ketentuan nilai sudah mencukupi untuk Peringkat Baik Sekali</strong>
        </div>';
        } else {
            $keputusan = "N";
            $pesan = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Menurut ketentuan nilai belum mencukupi untuk Peringkat Baik Sekali</strong>
        </div>';
        }

        $element->update([
            'min_baik' => floatval($request->min),
            'status_baik' => $keputusan,
        ]);

        session()->flash('pesan', $pesan);
        return redirect()->route('element-prodi', $prodi->kode);
    }

    public function resetData(Element $element)
    {
        $element->update([
            'score_berkas' => 0,
            'score_hitung' => 0,
            'count_berkas' => 0,
            'min_akreditasi' => 0,
            'status_akreditasi' => "F",
            'min_unggul' => 0,
            'status_unggul' => "F",
            'min_baik' => 0,
            'status_baik' => "F",
        ]);

        Berkas::where('element_id', $element->id)->delete();

        $prodi = Prodi::where('id', $element->prodi_id)->first();

        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Direset</strong></div>');
        return redirect()->route('element-prodi', $prodi->kode);
    }

    public function konfirHapus(Element $element)
    {
        return view('element.konfirmasi', [
            'element' => $element,
            'prodi' => Prodi::where('id', $element->prodi_id)->first(),
        ]);
    }

    public function delete(Element $element)
    {
        $prodi = Prodi::where('id', $element->prodi_id)->first();
        Berkas::where('element_id', $element->id)->delete();
        $element->delete();
        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Dihapus</strong></div>');
        return redirect()->route('element-prodi', $prodi->kode);
    }

    public function detailElement(Element $element)
    {
        return view('element.detail', [
            'element' => $element,
            'prodi' => Prodi::where('id', $element->prodi_id)->first(),
        ]);
    }

    public function putBobot(Element $element, Request $request)
    {
        $element->update([
            'bobot' => $request->bobot,
        ]);

        return redirect()->to('/element/detail/' . $element->id);
    }

    public function putPenilaianAuditor(Element $element, Request $request)
    {
        $score_hitung = floatval($request->score_auditor) * floatval($element->bobot);
        $element->update([
            'ket_auditor' => $request->ket_auditor,
            'score_auditor' => floatval($request->score_auditor),
            'score_hitung' => floatval($score_hitung),
        ]);
        return redirect()->to('/element/lihat-berkas/' . $element->id);
    }
}
