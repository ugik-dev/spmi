<?php

namespace App\Http\Controllers;

use App\Element;
use App\Jenjang;
use App\L1;
use App\Prodi;
use App\Target;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index(Request $request, $prodi)
    {
        $p = Prodi::where('kode', $prodi)->first();

        $element = Element::where('prodi_id', $p->id);
        $rendah = Element::where('prodi_id', $p->id)->where('score_hitung', '<', 0.5)->get();

        $target = [
            "l1" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 1)->first(),
            "l2" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 2)->first(),
            "l3" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 3)->first(),
            "l4" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 4)->first(),
            "l5" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 5)->first(),
            "l6" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 6)->first(),
            "l7" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 7)->first(),
            "l8" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 8)->first(),
            "l9" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 9)->first(),
            "l10" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 10)->first(),
            "l11" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 11)->first(),
            "l12" => Target::where("prodi_id", '=', $p->id)->where("l1_id", 12)->first(),
        ];

        $pencapaian = [
            "l1" => Element::where('prodi_id', $p->id)->where('l1_id', 1)->sum('score_hitung'),
            "l2" => Element::where('prodi_id', $p->id)->where('l1_id', 2)->sum('score_hitung'),
            "l3" => Element::where('prodi_id', $p->id)->where('l1_id', 3)->sum('score_hitung'),
            "l4" => Element::where('prodi_id', $p->id)->where('l1_id', 4)->sum('score_hitung'),
            "l5" => Element::where('prodi_id', $p->id)->where('l1_id', 5)->sum('score_hitung'),
            "l6" => Element::where('prodi_id', $p->id)->where('l1_id', 6)->sum('score_hitung'),
            "l7" => Element::where('prodi_id', $p->id)->where('l1_id', 7)->sum('score_hitung'),
            "l8" => Element::where('prodi_id', $p->id)->where('l1_id', 8)->sum('score_hitung'),
            "l9" => Element::where('prodi_id', $p->id)->where('l1_id', 9)->sum('score_hitung'),
            "l10" => Element::where('prodi_id', $p->id)->where('l1_id', 10)->sum('score_hitung'),
            "l11" => Element::where('prodi_id', $p->id)->where('l1_id', 11)->sum('score_hitung'),
            "l12" => Element::where('prodi_id', $p->id)->where('l1_id', 12)->sum('score_hitung'),

        ];

        return view('penilaian.index', [
            'p' => $p,
            'e' => $element->get(),
            'count_element' => $element->count(),
            'count_berkas' => $element->sum("count_berkas"),
            'score_hitung' => $element->sum("score_hitung"),
            'alert' => $rendah,
            'terakreditas' => $element->where('status_akreditasi', "Y")->get(),
            'unggul' => $element->where('status_unggul', "Y")->get(),
            'baik' => $element->where('status_baik', "Y")->get(),
            'target' => $target,
            'pencapaian' => $pencapaian,
        ]);
    }
    public function butir(Prodi $prodi, $label)
    {

        $label = preg_replace('/%20/', ' ', $label);
        $jenjang = Jenjang::where('id', $prodi->jenjang_id)->first();
        $butir = L1::where('jenjang_id', $jenjang->id)->where('name', $label)->first();
        $element = Element::where('l1_id', $butir->id)->where('prodi_id', $prodi->id)->get();
        $target = Target::where("prodi_id", '=', $prodi->id)->where("l1_id", $butir->id)->first();
        $pencapaian = Element::where('prodi_id', $prodi->id)->where('l1_id', $butir->id)->sum('score_hitung');
        $avg = $target->value / $element->count();

        return view('penilaian.informasi', [
            'p' => $prodi,
            'e' => $element,
            'label' => $label,
            'target' => $target,
            'pencapaian' => $pencapaian,
            'avg' => $avg,
        ]);
    }
    public function profil(Prodi $prodi)
    {
        return view('prodi.profil', [
            'p' => $prodi,
            'edit' => true
        ]);
    }
    public function editprofil()
    {
        $prodi = Prodi::where('kode', Auth::user()->prodi_kode)->get()[0];
        return view('prodi.form-profil', [
            'edit' => true,
            'i' => $prodi,
        ]);
    }

    public function editprofilPut(Request $request, Prodi $prodi)
    {
        $attr = [
            'deskripsi' => $request->deskripsi,
            'visi' => $request->visi,
            'misi' => $request->misi,
        ];

        if ($request->hasFile('foto_file') && $request->input('ganti_gambar')) {
            $photo = $request->file('foto_file');
            $originalFilename = $photo->getClientOriginalName(); // Ambil nama asli file
            $path = $photo->storeAs('prodi', $originalFilename, 'local'); // Simpan file dengan nama asli
            $prodi->foto = $originalFilename; // Simpan nama asli file ke dalam atribut foto pada model
            $prodi->save();
        }


        $prodi->update($attr);

        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Data Berhasil Diedit</strong></div>');

        return redirect()->route('profil-prodi', $prodi->kode);
    }
}
