@extends('template.BaseView')
@section('content')
<style>
    .hr-lv1 {
        border: 1px solid;
        width: 1px;
        display: inline-block;
        vertical-align: middle;
    }

    .hr-lv2 {
        border: 1px solid;
        width: 10px;
        display: inline-block;
        vertical-align: middle;
    }

    .hr-lv3 {
        border: 1px solid;
        width: 20px;
        display: inline-block;
        vertical-align: middle;
    }

    .hr-lv4 {
        border: 1px solid;
        width: 30px;
        display: inline-block;
        vertical-align: middle;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{url('kriteria-lam')}}" id="toolbar" method="GET">
                    <h4 class="card-title">Filter</h4>
                    <div class="row">

                        <div class="col-3">
                            <select class="form-control" id="level" name="level" onchange="this.form.submit()">
                                <option value="">-- Semua Level --</option>
                                <option value="1">Level 1</option>
                                <option value="2">Level 2</option>
                                <option value="3">Level 3</option>
                                <option value="4">Level 4</option>

                            </select>
                        </div>
                        <div class="col-3">
                            <select class="form-control" id="lembaga" name="lembaga" onchange="this.form.submit()">
                                <option value="">-- Lembaga --</option>
                                @foreach($lembaga as $lem)
                                <option value="{{$lem->id}}" {{$lem->id == $filter['lembaga_id'] ? 'selected' : ''}}>{{$lem->name}}</option>
                                @endforeach


                            </select>
                        </div>
                        <div class="col-3">
                            <select class="form-control" id="jenjang" name="jenjang" onchange="this.form.submit()">
                                <option value="">-- Jenjang --</option>
                                @foreach($jenjang as $jen)
                                <option value="{{$jen->id}}" {{$jen->id == $filter['jenjang_id'] ? 'selected' : ''}}>{{$jen->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <!-- <h4 class="card-title">Aksi</h4> -->
                            <button type="button" class="btn btn-primary btn-sm float-right" id="CreateNew">
                                Tambah LV 1
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Kriteria</h6>
            </div>
            <div class="card-body">
                @if (session()->has('pesan'))
                {!! session()->get('pesan') !!}
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered" id="TKriteria" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Lv1</th>
                                <th>Lv2</th>
                                <th>Lv3</th>
                                <th>Lv4</th>
                                <th>Kode</th>
                                <th>Name</th>
                                <th width="10px">Level</th>
                                <th width="120px">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            function renderBtnK($lv, $id, $kode)
                            {
                                return
                                    '
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                ' . ($lv != 4 ? ('<a class="addsub dropdown-item" data-id="' . $id . '" data-lv="' . $lv . '" ><i class="fa fa-plus"></i> Tambah Sub </a>') : '') . '
                                                    <a class="edit dropdown-item" data-id="' . $id . '" data-lv="' . $lv . '" ><i class="fa fa-pencil"></i> Edit </a>
                                                     <a class="delete dropdown-item text-danger" data-id="' . $id . '" data-lv="' . $lv . '" ><i class="fa fa-trash"></i> Hapus </a>
                                                      </div>
                                                </div>
                                               ' . ($lv != 4 ? (' <button data-name="' . $kode . '"  data-curstatus="show" id="headingOne" data-target=".kode-' . str_replace('.', '-', $kode) . '" class="btn-colapsed btn btn-info"><i class="fa fa-eye"></i></button>') : '');
                            }
                            ?>
                            @foreach ($r as $i)
                            <tr>
                                <td>{{ $i['kode'] }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <hr class="hr-lv1"> {{ $i['kode'] }}
                                </td>
                                <td>{{ $i['name'] }}</td>
                                <td>1</td>
                                <td width="150px">
                                    <?= renderBtnK(1, $i['id'], $i['kode']) ?>
                                </td>
                            </tr>
                            @foreach($i['children'] as $l2)
                            @if(!empty($l2['id']))
                            <tr class="kode-{{ str_replace('.','-',$i['kode']) }}" class="btn-colapsed" data-parent="">
                                <td>{{ $i['kode'] }}</td>
                                <td>{{ $l2['kode'] }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <hr class="hr-lv2"> {{ $l2['full_kode'] }}
                                </td>
                                <td>{{ $l2['name'] }}</td>
                                <td>2</td>
                                <td width="150px">
                                    <?= renderBtnK(2, $l2['id'], $l2['kode']) ?>
                                </td>
                            </tr>
                            @else
                            <tr class="kode-{{ str_replace('.','-',$i['kode']) }}" class="btn-colapsed" data-parent="">
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                            </tr>
                            <?php $l2['kode'] = ''; ?>
                            @endif
                            @foreach($l2['children'] as $l3)
                            @if(!empty($l3['id']))
                            <tr class="kode-{{ str_replace('.','-',$i['kode']) }} kode-{{ str_replace('.','-',$l2['kode']) }}" data-parent="">
                                <td>{{ $i['kode'] }}</td>
                                <td>{{ $l2['kode'] }}</td>
                                <td>{{ $l3['kode'] }}</td>
                                <td></td>
                                <td>
                                    <hr class="hr-lv3"> {{ $l3['full_kode'] }}
                                </td>
                                <td>{{ $l3['name'] }}</td>
                                <td>3</td>
                                <td width="150px">
                                    <?= renderBtnK(3, $l3['id'], $l3['kode']) ?>
                                </td>
                            </tr>
                            @endif
                            @foreach($l3['children'] as $l4)
                            @if(!empty($l4['id']))
                            <tr class="kode-{{ str_replace('.','-',$i['kode']? $i['kode'] : '') }} kode-{{ str_replace('.','-',$l2['kode']? $l2['kode'] : '') }} kode-{{ str_replace('.','-', !empty($l3['kode'])? $l3['kode'] : '') }}" data-parent="">
                                <td>{{ $i['kode'] }}</td>
                                <td>{{ $l2['kode'] }}</td>
                                <td>{{ $l3['kode'] }}</td>
                                <td>{{ $l4['kode'] }}</td>
                                <td>
                                    <hr class="hr-lv4"> {{ $l4['full_kode'] }}
                                </td>
                                <td>{{ $l4['name'] }}</td>
                                <td>4</td>
                                <td width="150px">
                                    <?= renderBtnK(4, $l4['id'], $l4['kode']) ?>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @endforeach
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="modalKritNew" tabindex="-1" role="dialog" style="background : rgba(158, 167, 170, 0.6) !important" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="krit_form_new">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Tambah Kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="">Info Sub Kriteria</label>
                        <p id="parent_info"></p>
                        <!-- <textarea type="text" name="parent_name" id="parent_name" class="form-control" placeholder="" readonly aria-describedby="helpId"></textarea> -->
                    </div>
                    <hr>

                    <div class="form-group">
                        <label for="">Kode - Nama</label>
                        <div class="input-group">
                            <div class="input-group-append" id="layout_parent_kode">
                                <span class="input-group-text" id="val_parent_kode"></span>
                            </div>
                            <input type="text" class="form-control" style="max-width: 50px !important" id="kode" name="kode">
                            <div class="input-group-append">
                                <span class="input-group-text">. </span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <input type="hidden" name="lv" id="lv" class="form-control" value="">
                    <input type="hidden" name="id" id="id" class="form-control" value="">
                    <input type="hidden" name="parent" id="parent" class="form-control" value="">
                    <input type="hidden" name="jenjang" class="form-control" value="{{$filter['jenjang_id']}}">
                    <input type="hidden" name="lembaga_id" class="form-control" value="{{$filter['lembaga_id']}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalKrit" tabindex="-1" role="dialog" style="background : rgba(158, 167, 170, 0.6) !important" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="krit_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Edit Kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="">Info Sub Kriteria</label>
                        <p id="parent_info"></p>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="">Kode - Nama</label>
                        <div class="input-group">
                            <div class="input-group-append" id="layout_parent_kode">
                                <span class="input-group-text" id="val_parent_kode"></span>
                            </div>
                            <input type="text" class="form-control" style="max-width: 50px !important" id="kode" name="kode">
                            <div class="input-group-append">
                                <span class="input-group-text">. </span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <input type="hidden" name="id" id="id" class="form-control" value="">
                    <input type="hidden" name="jenjang" class="form-control" value="{{$filter['jenjang_id']}}">
                    <input type="hidden" name="lembaga_id" class="form-control" value="{{$filter['lembaga_id']}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {

        // $('#parent').select2();
        var ModalKrit = {
            'self': $('#modalKrit'),
            'form': $('#modalKrit').find('#krit_form'),
            'id': $('#modalKrit').find('#id'),
            'name': $('#modalKrit').find('#name'),
            'kode': $('#modalKrit').find('#kode'),
            'parent_info': $('#modalKrit').find('#parent_info'),
            'layout_parent_kode': $('#modalKrit').find('#layout_parent_kode'),
            'val_parent_kode': $('#modalKrit').find('#val_parent_kode'),

        };

        var toolbar = {
            'form': $('#toolbar'),
            'level': $('#toolbar').find('#level'),
        }

        toolbar.level.on('change', function() {
            console.log('ch')
            toolbar.form.submit();
        })

        var ModalKritNew = {
            'self': $('#modalKritNew'),
            'form': $('#modalKritNew').find('#krit_form_new'),
            'id': $('#modalKritNew').find('#id'),
            'name': $('#modalKritNew').find('#name'),
            'kode': $('#modalKritNew').find('#kode'),
            'parent': $('#modalKritNew').find('#parent'),
            'parent_info': $('#modalKritNew').find('#parent_info'),
            'layout_parent_kode': $('#modalKritNew').find('#layout_parent_kode'),
            'val_parent_kode': $('#modalKritNew').find('#val_parent_kode'),
            'lv': $('#modalKritNew').find('#lv'),
        };


        $('.btn-colapsed')
            .on('click', function() {
                target = $(this).data('target');
                const curstatus = $(this).data('curstatus');
                if (curstatus == 'show') {
                    $(this)
                        .find('.fa-eye')
                        .removeClass("fa-eye")
                        .addClass("fa-eye-slash");
                    $(target).css('display', 'none')
                    $(this).data('curstatus', 'hide');
                } else {
                    $(this)
                        .find('.fa-eye-slash')
                        .removeClass("fa-eye-slash")
                        .addClass("fa-eye");
                    $(target).css('display', '')
                    $(this).data('curstatus', 'show');
                }
            });

        var collapsedGroups = {};
        var TKriteria = $('#TKriteria').DataTable({
            "paging": false,
            "columns": [{
                    "visible": false
                },
                {
                    "visible": false
                },
                {
                    "visible": false
                },
                {
                    "visible": false
                },
                null,
                null,
                null,
                null,
            ],
            'ordering': false
        });

        $('#CreateNew').on('click', () => {
            console.log('cr');
            ModalKritNew.self.modal('show')
            ModalKritNew.form.trigger('reset');
            ModalKritNew.lv.val('1');
            ModalKritNew.parent.val('');
            ModalKritNew.layout_parent_kode.hide();
            ModalKritNew.parent_info.html('-');

        })
        TKriteria.on('click', '.addsub', function() {
            var id = $(this).data('id');
            var lv = $(this).data('lv');
            swalLoading();
            $.ajax({
                url: `<?= url('search-kriteria-lam') ?>`,
                'type': 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    var json = JSON.parse(data);
                    Swal.close();
                    if (json['error']) {
                        swalError(json['message'], "Simpan Gagal !!");
                        return;
                    }
                    var curDat = json['data'];
                    console.log(curDat)

                    ModalKritNew.self.modal('show')
                    ModalKritNew.form.trigger('reset');
                    ModalKritNew.lv.val(lv + 1);
                    ModalKritNew.parent.val(id);
                    ModalKritNew.parent_info.html(curDat['val_parent'].replace(/\n/g, '<br>'));
                    ModalKritNew.layout_parent_kode.show();
                    ModalKritNew.val_parent_kode.html(curDat['full_kode']);
                },
                error: function(e) {}
            });
        });


        TKriteria.on('click', '.edit', function() {

            var id = $(this).data('id');
            var lv = $(this).data('lv');
            ModalKrit.form.trigger('reset');

            swalLoading();
            $.ajax({
                url: `<?= url('search-kriteria-lam') ?>`,
                'type': 'GET',
                data: {
                    'id': id
                },
                success: function(data) {
                    var json = JSON.parse(data);
                    Swal.close();
                    if (json['error']) {
                        swalError(json['message'], "Simpan Gagal !!");
                        return;
                    }
                    var curDat = json['data'];
                    console.log(curDat)
                    ModalKrit.self.modal('show')
                    ModalKrit.id.val(curDat['id'])
                    ModalKrit.kode.val(curDat['kode'])
                    ModalKrit.name.val(curDat['name'])
                    if (curDat['level'] == 1) {
                        ModalKrit.parent_info.html('-')
                        ModalKrit.layout_parent_kode.hide();

                    } else {
                        ModalKrit.parent_info.html(curDat['val_cur_parent'].replace(/\n/g, '<br>'));
                        ModalKrit.layout_parent_kode.show();
                        ModalKrit.val_parent_kode.html(curDat['parent']['full_kode']);
                    }

                },
                error: function(e) {}
            });

        });
        ModalKrit.form.on('submit', function(ev) {
            ev.preventDefault();

            Swal.fire(SwalOpt()).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                swalLoading();
                $.ajax({
                    url: `<?= url('kriteria-lam/put/') ?>`,
                    'type': 'PUT',
                    data: ModalKrit.form.serialize(),
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swalError(json['message'], "Simpan Gagal !!");
                            return;
                        }
                        swalBerhasil();
                        location.reload()
                    },

                    error: function(e) {}
                });
            });

        });
        ModalKritNew.form.on('submit', function(ev) {
            ev.preventDefault();

            Swal.fire(SwalOpt()).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                swalLoading();
                $.ajax({
                    url: `<?= url('kriteria-lam/tambahbaru/') ?>`,
                    'type': 'POST',
                    data: ModalKritNew.form.serialize(),
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swalError(json['message'], "Simpan Gagal !!");
                            return;
                        }
                        swalBerhasil();
                        location.reload()
                    },

                    error: function(e) {}
                });
            });

        });
        TKriteria.on('click', '.delete', function() {
            var id = $(this).data('id');

            Swal.fire(SwalOpt('Apakah anda yakin?', 'data akan dihapus!')).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                swalLoading();
                $.ajax({
                    url: `<?= url('kriteria-lam/delete/') ?>`,
                    'type': 'DELETE',
                    data: {
                        id: id,
                        _token: '<?= csrf_token() ?>'
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        Swal.close();
                        if (json['error']) {
                            swalError(json['message'], "Hapus Gagal !!");
                            return;
                        }
                        swalBerhasil();
                        location.reload();
                    },
                    error: function(e) {}
                });
            });

        });
    })
</script>
@endsection