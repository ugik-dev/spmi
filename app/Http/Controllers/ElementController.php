<?php

namespace App\Http\Controllers;

use App\Degree;
use Illuminate\Http\Request;
use App\StudyProgram;
use App\Element;
use App\Faculty;
use App\Indikator;

class ElementController extends Controller
{
    public function index(Request $request)
    {
        // $p = StudyProgram::where('code', $prodi)->first();
        // dd
        // $element = Element::where('prodi_id', $p->id)->get();
        $element = Element::get();
        dd($element);

        return view('element.index', [
            'p' => $p,
            'e' => $element,
            'count_element' => $element->count(),
            'count_berkas' => $element->sum("count_berkas"),
            'score_hitung' => $element->sum("score_hitung"),
        ]);
    }

    public function sync(Request $request)
    {
        // dd($request->input());
        // $fakultas = Faculty::with('studyPrograms')->get();
        // dd($fakultas);
        $prodi = StudyProgram::where('degree_id', $request->degree_id)
            ->where('institution_id', $request->institution_id)
            ->get();
        $indikator = Indikator::selectRaw('indikators.*')
            ->join('kriteria', 'kriteria.id', '=', 'indikators.l1_id')
            ->where('kriteria.degree_id', $request->degree_id)
            ->where('kriteria.institution_id', $request->institution_id)
            ->orderBy('id', 'ASC')->get();
        $jenjang = Degree::where('id', $request->degree_id)->get()->first();
        // dd($indikator);
        // dd($prodi);
        $row = [];
        foreach ($indikator as $i) {
            foreach ($prodi as $p) {
                // $score_hitung = $i->bobot * Element->score_auditor;
                Element::updateOrCreate(
                    [
                        'study_program_id' => $p->id,
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
        return redirect()->to('indikator?institution=' . $request->institution_id . '&degree=' . $request->degree_id);
    }
}
