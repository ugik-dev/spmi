@extends('template.BaseView')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $element->l1->name }}</h4>
                    <p class="card-text">{{ empty($element->l2->name) ? '' : $element->l2->name }}</p>
                    <p class="card-text">{{ empty($element->l3->name) ? '' : $element->l3->name }}</p>
                    <p class="card-text">{{ empty($element->l4->name) ? '' : $element->l4->name }}</p>
                </div>
            </div>
            <hr>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Unggah Berkas</h4>
                    @if (session()->has('pesan'))
                        {!! session()->get('pesan') !!}
                    @endif
                    <form action="/element/store-berkas" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Name Berkas</label>
                            <input type="text" name="element_id" value="{{ $element->id }}" hidden>
                            <input type="text" name="file_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Berkas</label>
                            <input type="file" accept=".pdf,.docx,.csv,.xls,.xlsx" class="form-control" name="file">
                            <small id="helpId" class="text-muted">Upload Berkas</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            @if ($score->count() >= 1)
                                <label>Score</label>
                                @foreach ($score as $i)
                                    <div class='form-check'><input class='form-check-input' type='radio' name='score'
                                            value='{{ $i->value }}' required>
                                        <label class='form-check-label'>{!! $i->name !!}</label>
                                    </div>
                                @endforeach
                            @else
                                @if (Auth::user()->role === 'Auditor' || Auth::user()->role === 'Admin')
                                    <div class="form-group">
                                        {!! $indikator->dec !!}
                                        <hr>
                                        <label>Score Input Manual</label>
                                        <input type="text" class="form-control" name="score" required>
                                        <small id="helpId" class="text-muted">Masukan nilai dengan menambahkan titik
                                            3.50</small>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="dec"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn-primary btn-sm" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('dec');
            CKEDITOR.replace('name');
        });
    </script>
@endsection
