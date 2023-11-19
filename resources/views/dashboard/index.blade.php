@extends('template.BaseView')

@section('content')
    <div class="bg-white py-3 px-4">
        @can('see prodis')
            <div class="row row-cols-1 row-cols-md-2">

            </div>
        @endcan
    </div>
@endsection
