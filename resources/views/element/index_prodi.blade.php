@extends('template.BaseView')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Element {{ $p->name }}</h6>
                </div>
                <div class="card-body">
                    @if (session()->has('pesan'))
                        {!! session()->get('pesan') !!}
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>Kriteria</th>
                                    <th>Indikator</th>
                                    <th>Bobot</th>
                                    <th>Score</th>
                                    <th>Hasil</th>
                                    <th>Jumlah Berkas</th>
                                    <th width="150px">Berkas & Ketentuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($element as $indi)
                                    <tr>
                                        <td>
                                            <?= !empty($indi->l1->name) ? $indi->l1->name : '' ?>
                                            <?= !empty($indi->l2->name) ? '<br>' . $indi->l2->name : '' ?>
                                            <?= !empty($indi->l3->name) ? '<br>' . $indi->l3->name : '' ?>
                                            <?= !empty($indi->l4->name) ? '<br>' . $indi->l4->name : '' ?>
                                        </td>
                                        <td> {{ $indi->indikator->dec }}</td>
                                        <td> {{ $indi->bobot }}</td>
                                        <td> {{ $indi->score_auditor }}</td>
                                        <td> {{ $indi->score_hitung }}</td>
                                        <!-- <td> {{ $indi->deskripsi ?: '-' }}</td> -->
                                        <td> {{ count($indi->berkas) == 0 ? '-' : count($indi->berkas) . ' Berkas' }}</td>

                                        <td>
                                            <a class="btn btn-primary w-100" href="{{ url('element/detail', $indi->id) }}">
                                                Detail
                                            </a>
                                            <hr>
                                            @if (Auth::user()->role != 'Auditor')
                                                <div class="dropdown open">
                                                    <button class="btn btn-primary dropdown-toggle w-100" type="button"
                                                        id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Berkas
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="triggerId">
                                                        <a class="dropdown-item"
                                                            href="{{ url('element/unggah-berkas/' . $indi->id) }}">Unggah
                                                            Berkas</a>
                                                        <a class="dropdown-item"
                                                            href="{{ url('element/lihat-berkas/' . $indi->id) }}">Lihat
                                                            Berkas</a>
                                                    </div>
                                                </div>
                                            @else
                                                <a class="btn btn-primary w-100"
                                                    href="{{ url('element/lihat-berkas/' . $indi->id) }}">
                                                    Berkas
                                                </a>
                                            @endif
                                            <hr>
                                            <div class=" dropdown open">
                                                <button {{ Auth::user()->role == 'Prodi' ? 'hidden' : '' }}
                                                    class="btn btn-info dropdown-toggle w-100" type="button" id="triggerId"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Ketentuan
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                                    <a class="dropdown-item"
                                                        href="{{ url('element/syarat-akreditasi/' . $indi->id) }}">Syarat
                                                        Perlu Akreditasi</a>
                                                    <a class="dropdown-item"
                                                        href="{{ url('element/syarat-unggul/' . $indi->id) }}">Syarat
                                                        Peringkat Unggul</a>
                                                    <a class="dropdown-item"
                                                        href="{{ url('element/syarat-baik/' . $indi->id) }}">Syarat
                                                        Peringkat Baik Sekali</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Report</h4>
                    Element = {{ $count_element }}<br>
                    Berkas = {{ $count_berkas }}<br>
                    Score = {{ $score_hitung }}
                </div>
            </div>
        </div>
    </div>
@endsection
