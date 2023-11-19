<?php

namespace App\Http\Controllers;

use App\Jenjang;
use App\L1;
use App\L2;
use App\L3;
use App\L4;
use App\Kriteria;
use App\Lembaga;
use App\Indikator;
use App\IndikatorLam;
use Illuminate\Http\Request;
use Exception;

class KriteriaController extends Controller
{
    public function index()
    {
        $j = Jenjang::where('kode', '<>', 'NULL')->get();
        return view('kriteria.m2', [
            'j' => $j,
        ]);
    }

    public function index_lam(Request $req)
    {
        if (empty($req->input('lembaga'))) $filter['lembaga_id'] = 1;
        else  $filter['lembaga_id'] = $req->input('lembaga');

        if (empty($req->input('jenjang'))) $filter['jenjang_id'] = 1;
        else  $filter['jenjang_id'] = $req->input('jenjang');

        $j = Jenjang::where('kode', '<>', 'NULL')->get();
        $r = Kriteria::GetChild($filter);
        $l = Lembaga::get();

        return view('kriteria.lam', [
            'jenjang' => $j,
            'r' => $r,
            'lembaga' => $l,
            'filter' => $filter,
        ]);
    }

    function update_new_indikator()
    {
        $ind = Indikator::with(['l1', 'l2', 'l3', 'l4'])->get()->toArray();
        $new_ind = [];
        foreach ($ind as $i) {
            $tmp = [
                'id' => $i['id'],
                'jenjang_id' => $i['jenjang_id'],
                'dec' => $i['dec'],
                'bobot' => $i['bobot'],
                'l1_id' => null,
                'l2_id' => null,
                'l3_id' => null,
                'l4_id' => null,
            ];

            $l1 = $i['l1']['name'];

            $l1_kode = explode('. ', $l1, 2);
            $l1_name = isset($l1_kode[1]) ? $l1_kode[1] : '';

            // echo $l1_kode[0];
            // echo $l1_name;
            if (!empty($l1_kode[0]) && !empty($l1_name)) {
                $l1krite = Kriteria::whereRaw('BINARY kode = ?', $l1_kode[0])
                    ->whereRaw('BINARY name = ?', $l1_name)
                    ->where('jenjang_id', $i['jenjang_id'])
                    ->where('level', 1)
                    ->get();
                if ($l1krite->count() > 1) {
                    echo "data lebih dari 1";
                    dd($l1krite);
                };
                $tmp['l1_id'] = $l1krite[0]->id;
                // dd($l1krite);
            } else {
                echo "Ade yg salah bro di L1";
                die();
            }
            if (!empty($i['l2']['name'])) {
                $l2 = $i['l2']['name'];
                $l2_kode = explode('. ', $l2, 2);
                $l2_name = isset($l2_kode[1]) ? $l2_kode[1] : '';
                $l2_tmp_kode = explode('.', $l2_kode[0]);
                $l2_tmp_kode = end($l2_tmp_kode);
                // echo $l2_name;
                // die();
                if (!empty($l2_tmp_kode) && !empty($l2_name)) {
                    $l2krite = Kriteria::whereRaw('BINARY kode = ?', $l2_tmp_kode)
                        ->whereRaw('BINARY name = ?', $l2_name)
                        ->where('level', 2)
                        ->where('parent_id', $l1krite[0]->id)
                        ->get();
                    if ($l2krite->count() > 1 || empty($l2krite[0])) {
                        echo "data lebih dari 1 L2 atau kosong";
                        dd($l2krite);
                    };
                    // dd($l2krite);
                    $tmp['l2_id'] = $l2krite[0]->id;

                    if (!empty($i['l3']['name'])) {
                        $l3 = $i['l3']['name'];
                        $l3_kode = explode('. ', $l3, 2);
                        $l3_name = isset($l3_kode[1]) ? $l3_kode[1] : '';
                        $l3_tmp_kode = explode('.', $l3_kode[0]);
                        $l3_tmp_kode = end($l3_tmp_kode);
                        // echo $l3_name;
                        // dd($l3krite);

                        // die();
                        if (!empty($l3_tmp_kode) && !empty($l3_name)) {
                            $l3krite = Kriteria::whereRaw('BINARY kode = ?', $l3_tmp_kode)
                                ->whereRaw('BINARY name = ?', $l3_name)
                                ->where('level', 3)
                                ->where('parent_id', $l2krite[0]->id)
                                ->get();
                            if ($l3krite->count() > 1 || empty($l3krite[0])) {
                                echo $l3_tmp_kode;
                                echo ($l3_name);
                                echo "data lebih dari 1 L3 atau kosong";
                                dd($i);
                                dd($l3krite);
                            };
                            // dd($l3krite->count());
                            $tmp['l3_id'] = $l3krite[0]->id;
                            // dd($l3krite);

                            if (!empty($i['l4']['name'])) {
                                $l4 = $i['l4']['name'];
                                $l4_kode = explode('. ', $l4, 2);
                                $l4_name = isset($l4_kode[1]) ? $l4_kode[1] : '';
                                $l4_tmp_kode = explode('.', $l4_kode[0]);
                                $l4_tmp_kode = end($l4_tmp_kode);
                                // echo $l4_name;
                                // dd($l4krite);

                                // die();
                                if (!empty($l4_tmp_kode) && !empty($l4_name)) {
                                    $l4krite = Kriteria::whereRaw('BINARY kode = ?', $l4_tmp_kode)
                                        ->whereRaw('BINARY name = ?', $l4_name)
                                        ->where('level', 4)
                                        ->where('parent_id', $l3krite[0]->id)
                                        ->get();
                                    if ($l4krite->count() > 1 || empty($l4krite[0])) {
                                        echo $l4_tmp_kode;
                                        echo $l4_name;
                                        // dd($l4krite);
                                        echo "data lebih dari 1 L4 atau kosong";
                                        dd($l4krite);
                                    };
                                    $tmp['l4_id'] = $l4krite[0]->id;

                                    // dd($l4krite->count());
                                    // dd($l4krite);
                                } else {
                                    echo "Ade yg salah bro di L4";
                                    die();
                                }
                            }
                        } else {
                            echo "Ade yg salah bro di L3";
                            die();
                        }
                    }
                } else {
                    echo "Ade yg salah bro di L2";
                    die();
                }
            }
            $new_ind[] = $tmp;
        }
        IndikatorLam::insert($new_ind);
        dd($new_ind);
        // return;
    }

    function update_kriteria($jen)
    {
        // Kriteria::whereRaw('1 = 1')->delete();
        $j = Jenjang::where('id', $jen)->orderBy('id', 'ASC')->first();
        // dd($j->id);

        $l1 = L1::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray(); //A
        $l2 = L2::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode1 ,SUBSTRING_INDEX(name, '.', 2) AS kode")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray(); // A.1.2.3
        $l3 = L3::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode1 ,SUBSTRING_INDEX(name, '.', 2) AS kode2 ,SUBSTRING_INDEX(name, '.', 3) AS kode")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray(); // A
        $l4 = L4::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode1 ,SUBSTRING_INDEX(name, '.', 2) AS kode2 ,SUBSTRING_INDEX(name, '.', 3) AS kode3 ,SUBSTRING_INDEX(name, '.', 4) AS kode")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray();

        $r = $this->susun_level($l1, $l2, $l3, $l4);

        // dd($l1);
        $arr = [];

        foreach ($r as $l1) {
            $tmplv1 = [
                'kode' => $l1['kode'],
                'name' => $l1['s_name'],
                'jenjang_id' => $l1['jenjang_id'],
                'level' => 1,
                'lembaga_id' => 1,
            ];
            $id1 = Kriteria::insertGetId($tmplv1);

            if (!empty($id1)) {
                foreach ($l1['lv2'] as $l2) {
                    // dd($k);
                    // dd(end($k));
                    if (!empty($l2)) {
                        $k = explode('.', $l2['kode']);
                        $tmplv2 = [
                            'kode' => end($k),
                            'name' => $l2['s_name'],
                            'parent_id' => $id1,
                            'level' => 2,
                        ];
                        $id2 = Kriteria::insertGetId($tmplv2);
                        // lv3 start
                        if (!empty($id2)) {
                            foreach ($l2['lv3'] as $l3) {
                                if (!empty($l3)) {
                                    $k = explode('.', $l3['kode']);
                                    $tmplv3 = [
                                        'kode' => end($k),
                                        'name' => $l3['s_name'],
                                        'parent_id' => $id2,
                                        'level' => 3,
                                    ];
                                    $id3 = Kriteria::insertGetId($tmplv3);
                                    // lv4 start
                                    if (!empty($id3)) {
                                        foreach ($l3['lv4'] as $l4) {
                                            if (!empty($l4)) {
                                                $k = explode('.', $l4['kode']);
                                                $tmplv4 = [
                                                    'kode' => end($k),
                                                    'name' => $l4['s_name'],
                                                    'parent_id' => $id3,
                                                    'level' => 4,
                                                ];
                                                $id4 = Kriteria::insertGetId($tmplv4);
                                            }
                                        }
                                    }
                                    // lv4 end
                                }
                            }
                        }
                        // lv3 end
                    }
                }
            }
        }
    }


    public function getLam()
    {
        // $this->update_kriteria(1);
        // $this->update_kriteria(4);
        // $this->update_new_indikator();
        Kriteria::GetChild();
    }

    // public function index(Request $request)
    // {
    //     $kode = basename($request->path());
    //     $j = Jenjang::where('kode', $kode)->first();
    //     $c = L1::where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get();

    //     return view('kriteria.index', [
    //         'j' => $j,
    //         'c' => $c,
    //     ]);
    // }

    // Menampilkan per jenjang

    function searchQuery($lv)
    {

        $q1 = "TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1))";
    }

    public function detail(Request $request, $jenjang)
    {
        $j = Jenjang::where('kode', $jenjang)->first();
        // dd($j);
        $filter = $request->input();
        // $c = L1::where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray();
        $l1 = L1::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray(); //A
        $l2 = L2::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode1 ,SUBSTRING_INDEX(name, '.', 2) AS kode")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray(); // A.1.2.3
        $l3 = L3::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode1 ,SUBSTRING_INDEX(name, '.', 2) AS kode2 ,SUBSTRING_INDEX(name, '.', 3) AS kode")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray(); // A
        $l4 = L4::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode1 ,SUBSTRING_INDEX(name, '.', 2) AS kode2 ,SUBSTRING_INDEX(name, '.', 3) AS kode3 ,SUBSTRING_INDEX(name, '.', 4) AS kode")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray();
        // dd($filter);
        if (!empty($filter['level'])) {
            if ($filter['level'] == 1) {
                $l2 = [];
                $l3 = [];
                $l4 = [];
            } else if ($filter['level'] == 2) {
                $l3 = [];
                $l4 = [];
            } else if ($filter['level'] == 3) {
                $l4 = [];
            }
        } else {
            // $l1 = L1::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode1")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray(); //A
            // $l2 = L2::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode1 ,SUBSTRING_INDEX(name, '.', 2) AS kode2")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray(); // A.1.2.3
            // $l3 = L3::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode1 ,SUBSTRING_INDEX(name, '.', 2) AS kode2 ,SUBSTRING_INDEX(name, '.', 3) AS kode3")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray(); // A
            // $l4 = L4::select('*')->selectRaw("TRIM(BOTH ' ' FROM SUBSTRING_INDEX(name, SUBSTRING_INDEX(name, ' ', 1), -1)) as s_name, SUBSTRING_INDEX(name, '.', 1) AS kode1 ,SUBSTRING_INDEX(name, '.', 2) AS kode2 ,SUBSTRING_INDEX(name, '.', 3) AS kode3 ,SUBSTRING_INDEX(name, '.', 4) AS kode4")->where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get()->toArray();
        }
        // dd($l1);
        $r = $this->susun_level($l1, $l2, $l3, $l4);
        return view('kriteria.detail', [
            'j' => $j,
            'r' => $r,
        ]);
    }

    public function search($lv, $id)
    {
        $q_name = "SUBSTRING_INDEX(name, '.', 1) AS kode";
        if ($lv == 1) {
            $data = L1::select('*')->selectRaw($q_name)->where('id', $id)->get()->first()->toArray(); //A
        } else    if ($lv == 2) {
            $data = L2::select('*')->where('id', $id)->get()->first()->toArray(); //A
        } else    if ($lv == 3) {
            $data = L3::select('*')->where('id', $id)->get()->first()->toArray(); //A
        } else    if ($lv == 4) {
            $data = L4::select('*')->where('id', $id)->get()->first()->toArray(); //A
        }

        if (!empty($data)) {;
            $data['lv'] = $lv;
            echo json_encode(['error' => false, 'data' => $data]);
        } else
            echo json_encode(['error' => true, 'message' => "Data tidak ditemukan"]);
    }

    function susun_level($l1, $l2, $l3, $l4)
    {
        $arr = [];
        foreach ($l1 as $lv1) {
            $arr[$lv1['kode']] = $lv1;
            $arr[$lv1['kode']]['lv2'] = [];
        }
        foreach ($l2 as $lv2) {
            $arr[$lv2['kode1']]['lv2'][$lv2['kode']] = $lv2;
            $arr[$lv2['kode1']]['lv2'][$lv2['kode']]['lv3'] = [];
        }
        foreach ($l3 as $lv3) {
            $arr[$lv3['kode1']]['lv2'][$lv3['kode2']]['lv3'][$lv3['kode']] = $lv3;
            $arr[$lv3['kode1']]['lv2'][$lv3['kode2']]['lv3'][$lv3['kode']]['lv4'] = [];
        }
        foreach ($l4 as $lv4) {
            $arr[$lv4['kode1']]['lv2'][$lv4['kode2']]['lv3'][$lv4['kode3']]['lv4'][$lv4['kode']] = $lv4;
        }

        return $arr;
    }
    public function show($jenjang)
    {
        $j = Jenjang::where('kode', $jenjang)->first();
        $c = L1::where('jenjang_id', $j->id)->orderBy('id', 'ASC')->get();

        return view('kriteria.index', [
            'j' => $j,
            'c' => $c,
        ]);
    }

    public function store(Request $request)
    {
        $url = $request->url;
        L1::create([
            'name' => $request->name,
            'jenjang_id' => $request->jenjang,
        ]);
        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Ditambahkan</strong>
    </div>');
        return redirect()->to($url);
    }

    public function store_lam(Request $request)
    {
        try {
            if ($request->lv == 1) {
                $data = Kriteria::create([
                    'kode' => $request->kode,
                    'name' => $request->name,
                    'jenjang_id' => $request->jenjang,
                    'level' => 1,
                    'lembaga_id' => $request->lembaga_id,
                ]);
            } else {
                $data = Kriteria::create([
                    'kode' => $request->kode,
                    'name' => $request->name,
                    'level' => $request->lv,
                    'parent_id' => $request->parent,
                ]);
            }
            return  $this->Response($data);
        } catch (Exception $ex) {
            return  $this->ResponseError($ex->getMessage());
        }
    }

    public function edit_lam(Request $request)
    {
        try {
            $data = [
                'kode' => $request->kode,
                'name' => $request->name,
            ];
            $data = Kriteria::where('id', $request->id)->update($data);
            return  $this->Response($data);
        } catch (Exception $ex) {
            return  $this->ResponseError($ex->getMessage());
        }
    }
    public function delete_lam(Request $request)
    {
        try {
            $data = Kriteria::where('id', $request->id)->delete();
            return  $this->Response($data);
        } catch (Exception $ex) {
            return  $this->ResponseError($ex->getMessage());
        }
    }

    public function searchLam(Request $request)
    {
        try {

            $data = Kriteria::GetWithParent($request->input('id'));

            return  $this->Response($data);
        } catch (Exception $ex) {
            return  $this->ResponseError($ex->getMessage());
        }
    }

    public function delete(Request $request)
    {
        // $l1->delete();
        $req = $request->input();
        if ($req['lv'] == 1) {
            L1::where('id', $req['id'])->delete();
        } else if ($req['lv'] == 2) {
            L2::where('id', $req['id'])->delete();
        } else if ($req['lv'] == 3) {
            L3::where('id', $req['id'])->delete();
        } else if ($req['lv'] == 4) {
            L4::where('id', $req['id'])->delete();
        }
        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Dihapus</strong>
    </div>');
        echo json_encode(['error' => false]);
        // $url = $request->url;
        // return redirect()->to($url);
    }
    public function tambah(Request $request)
    {
        $req = $request->input();
        $data = [
            'jenjang_id' => $req['jenjang'],
            'name' => $req['name'],
        ];
        if ($req['lv'] == 1) {
            // echo "S";
            L1::insert($data);
        } else if ($req['lv'] == 2) {
            $data['l1_id'] = $req['parent'];
            L2::insert($data);
        } else if ($req['lv'] == 3) {
            $data['l2_id'] = $req['parent'];
            L3::insert($data);
        } else if ($req['lv'] == 4) {
            $data['l3_id'] = $req['parent'];
            L4::insert($data);
        }
        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Ditambah</strong>
    </div>');
        echo json_encode(['error' => false]);
    }
    public function rubah(Request $request)
    {
        $req = $request->input();
        if ($req['lv'] == 1) {
            L1::where('id', $req['id'])->update(['name' => $req['name']]);
        } else if ($req['lv'] == 2) {
            L2::where('id', $req['id'])->update(['name' => $req['name']]);
        } else if ($req['lv'] == 3) {
            L3::where('id', $req['id'])->update(['name' => $req['name']]);
        } else if ($req['lv'] == 4) {
            L4::where('id', $req['id'])->update(['name' => $req['name']]);;
        }
        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Dirubah</strong>
    </div>');
        echo json_encode(['error' => false]);
    }

    public function hapus(L1 $l1, Request $request)
    {
        $l1->delete();
        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Dihapus</strong>
    </div>');
        $url = $request->url;
        return redirect()->to($url);
    }

    public function put(L1 $l1, Request $request)
    {
        $l1->update([
            'name' => $request->name,
        ]);

        session()->flash('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Data Berhasil Diperbaharui</strong>
    </div>');
        $url = $request->url;
        return redirect()->to($url);
    }
}
