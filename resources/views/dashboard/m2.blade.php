@extends('template.BaseView')

@section('styles')
@endsection

@section('content')
<div id="accordion">
    <?php $i = 1; ?>
    @foreach($f as $fa)
    <div class="card mb-2">
        <div class="card-header" data-toggle="collapse" data-target="#collapse{{ $fa->id }}" aria-expanded="true" aria-controls="collapse{{ $fa->id }}" id="headingOne">
            <h5 class="mb-0">
                <!-- <button class="btn btn-info"> -->
                Fakultas {{ $fa->nama }}
                <!-- </button> -->
            </h5>
        </div>
        <div id="collapse{{ $fa->id }}" class="collapse {{$i == 1 ? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <!-- prodi -->
                <div class="row">

                    @foreach($fa['prodi'] as $p)
                    <div class="col-lg-4">

                        <div class="card mb-2" style="width: 100%;">
                            <img class="card-img-top" src="{{ $p->foto ? route('showimage', ['filename' => $p->foto]) : asset('home/img/about.png') }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">{{$p->name}}</h5>
                                <p class=" card-text">{{ substr(html_entity_decode(strip_tags(@$p->deskripsi)),0,150) }}..</p>
                                <a href="{{url('prodi/profil/'.$p->kode)}}" class="btn btn-primary">Lihat Profil</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- end prodi -->
            </div>
        </div>
    </div>
    <?php $i++ ?>
    @endforeach
</div>
@endsection