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
                <form action="{{url('kriteria')}}" id="toolbar" method="GET">
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
                            <select class="form-control" id="institutions" name="institutions" onchange="this.form.submit()">
                                <option value="">-- institutions --</option>
                                @foreach($institutions as $lem)
                                <option value="{{$lem->id}}" {{$lem->id == $filter['institution_id'] ? 'selected' : ''}}>{{$lem->name}}</option>
                                @endforeach


                            </select>
                        </div>
                        <div class="col-3">
                            <select class="form-control" id="degrees" name="degrees" onchange="this.form.submit()">
                                <option value="">-- degrees --</option>
                                @foreach($degrees as $jen)
                                <option value="{{$jen->id}}" {{$jen->id == $filter['degree_id'] ? 'selected' : ''}}>{{$jen->name}}</option>
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
                                <th>Code</th>
                                <th>Name</th>
                                <th width="10px">Level</th>
                                <th width="120px">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            function renderBtnK($lv, $id, $code)
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
                                               ' . ($lv != 4 ? (' <button data-name="' . $code . '"  data-curstatus="show" id="headingOne" data-target=".code-' . str_replace('.', '-', $code) . '" class="btn-colapsed btn btn-info"><i class="fa fa-eye"></i></button>') : '');
                            }
                            ?>
                            @foreach ($r as $i)
                            <tr>
                                <td>{{ $i['code'] }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <hr class="hr-lv1"> {{ $i['code'] }}
                                </td>
                                <td>{{ $i['name'] }}</td>
                                <td>1</td>
                                <td width="150px">
                                    <?= renderBtnK(1, $i['id'], $i['code']) ?>
                                </td>
                            </tr>
                            @foreach($i['children'] as $l2)
                            @if(!empty($l2['id']))
                            <tr class="code-{{ str_replace('.','-',$i['code']) }}" class="btn-colapsed" data-parent="">
                                <td>{{ $i['code'] }}</td>
                                <td>{{ $l2['code'] }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <hr class="hr-lv2"> {{ $l2['full_code'] }}
                                </td>
                                <td>{{ $l2['name'] }}</td>
                                <td>2</td>
                                <td width="150px">
                                    <?= renderBtnK(2, $l2['id'], $l2['code']) ?>
                                </td>
                            </tr>
                            @else
                            <tr class="code-{{ str_replace('.','-',$i['code']) }}" class="btn-colapsed" data-parent="">
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                            </tr>
                            <?php $l2['code'] = ''; ?>
                            @endif
                            @foreach($l2['children'] as $l3)
                            @if(!empty($l3['id']))
                            <tr class="code-{{ str_replace('.','-',$i['code']) }} code-{{ str_replace('.','-',$l2['code']) }}" data-parent="">
                                <td>{{ $i['code'] }}</td>
                                <td>{{ $l2['code'] }}</td>
                                <td>{{ $l3['code'] }}</td>
                                <td></td>
                                <td>
                                    <hr class="hr-lv3"> {{ $l3['full_code'] }}
                                </td>
                                <td>{{ $l3['name'] }}</td>
                                <td>3</td>
                                <td width="150px">
                                    <?= renderBtnK(3, $l3['id'], $l3['code']) ?>
                                </td>
                            </tr>
                            @endif
                            @foreach($l3['children'] as $l4)
                            @if(!empty($l4['id']))
                            <tr class="code-{{ str_replace('.','-',$i['code']? $i['code'] : '') }} code-{{ str_replace('.','-',$l2['code']? $l2['code'] : '') }} code-{{ str_replace('.','-', !empty($l3['code'])? $l3['code'] : '') }}" data-parent="">
                                <td>{{ $i['code'] }}</td>
                                <td>{{ $l2['code'] }}</td>
                                <td>{{ $l3['code'] }}</td>
                                <td>{{ $l4['code'] }}</td>
                                <td>
                                    <hr class="hr-lv4"> {{ $l4['full_code'] }}
                                </td>
                                <td>{{ $l4['name'] }}</td>
                                <td>4</td>
                                <td width="150px">
                                    <?= renderBtnK(4, $l4['id'], $l4['code']) ?>
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
                        <label for="">Code - Nama</label>
                        <div class="input-group">
                            <div class="input-group-append" id="layout_parent_code">
                                <span class="input-group-text" id="val_parent_code"></span>
                            </div>
                            <input type="text" class="form-control" style="max-width: 50px !important" id="code" name="code">
                            <div class="input-group-append">
                                <span class="input-group-text">. </span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <input type="hidden" name="lv" id="lv" class="form-control" value="">
                    <input type="hidden" name="id" id="id" class="form-control" value="">
                    <input type="hidden" name="kriteria_id" id="kriteria_id" class="form-control" value="">
                    <input type="hidden" name="degree_id" class="form-control" value="{{$filter['degree_id']}}">
                    <input type="hidden" name="institution_id" class="form-control" value="{{$filter['institution_id']}}">
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
                        <label for="">Code - Nama</label>
                        <div class="input-group">
                            <div class="input-group-append" id="layout_parent_code">
                                <span class="input-group-text" id="val_parent_code"></span>
                            </div>
                            <input type="text" class="form-control" style="max-width: 50px !important" id="code" name="code">
                            <div class="input-group-append">
                                <span class="input-group-text">. </span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <input type="hidden" name="id" id="id" class="form-control" value="">
                    <input type="hidden" name="degree_id" class="form-control" value="{{$filter['degree_id']}}">
                    <input type="hidden" name="institution_id" class="form-control" value="{{$filter['institution_id']}}">
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
        // $(function() {

        // $('#parent').select2();
        var ModalKrit = {
            'self': $('#modalKrit'),
            'form': $('#modalKrit').find('#krit_form'),
            'id': $('#modalKrit').find('#id'),
            'name': $('#modalKrit').find('#name'),
            'code': $('#modalKrit').find('#code'),
            'parent_info': $('#modalKrit').find('#parent_info'),
            'layout_parent_code': $('#modalKrit').find('#layout_parent_code'),
            'val_parent_code': $('#modalKrit').find('#val_parent_code'),

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
            'code': $('#modalKritNew').find('#code'),
            'parent': $('#modalKritNew').find('#kriteria_id'),
            'parent_info': $('#modalKritNew').find('#parent_info'),
            'layout_parent_code': $('#modalKritNew').find('#layout_parent_code'),
            'val_parent_code': $('#modalKritNew').find('#val_parent_code'),
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
            ModalKritNew.layout_parent_code.hide();
            ModalKritNew.parent_info.html('-');

        })
        TKriteria.on('click', '.addsub', function() {
            var id = $(this).data('id');
            var lv = $(this).data('lv');
            swalLoading();
            $.ajax({
                url: `<?= route('kriteria.search') ?>`,
                'type': 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    Swal.close();
                    if (data.error) {
                        swalError(data.message, "Simpan Gagal !!");
                        return;
                    }
                    console.log(data)
                    var curDat = data.data;
                    console.log(curDat)

                    ModalKritNew.self.modal('show')
                    ModalKritNew.form.trigger('reset');
                    ModalKritNew.lv.val(lv + 1);
                    ModalKritNew.parent.val(id);
                    ModalKritNew.parent_info.html(curDat['val_parent'].replace(/\n/g, '<br>'));
                    ModalKritNew.layout_parent_code.show();
                    ModalKritNew.val_parent_code.html(curDat['full_code']);
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
                url: `<?= route('kriteria.search') ?>`,
                'type': 'GET',
                data: {
                    'id': id
                },
                success: function(data) {
                    Swal.close();
                    if (data.error) {
                        swalError(data.message, "Simpan Gagal !!");
                        return;
                    }
                    var curDat = data.data;
                    console.log(curDat)
                    ModalKrit.self.modal('show')
                    ModalKrit.id.val(curDat['id'])
                    ModalKrit.code.val(curDat['code'])
                    ModalKrit.name.val(curDat['name'])
                    if (curDat['level'] == 1) {
                        ModalKrit.parent_info.html('-')
                        ModalKrit.layout_parent_code.hide();

                    } else {
                        ModalKrit.parent_info.html(curDat['val_cur_parent'].replace(/\n/g, '<br>'));
                        ModalKrit.layout_parent_code.show();
                        ModalKrit.val_parent_code.html(curDat['parent']['full_code']);
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
                    url: `<?= route('kriteria.edit') ?>`,
                    'type': 'patch',
                    data: ModalKrit.form.serialize(),
                    success: function(data) {
                        if (data.error) {
                            swalError(data.message, "Simpan Gagal !!");
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
                    url: `<?= route('kriteria.create') ?>`,
                    'type': 'POST',
                    data: ModalKritNew.form.serialize(),
                    success: function(data) {
                        if (data.error) {
                            swalError(data.message, "Simpan Gagal !!");
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
                    url: `<?= route('kriteria.delete') ?>`,
                    'type': 'DELETE',
                    data: {
                        id: id,
                        _token: '<?= csrf_token() ?>'
                    },
                    success: function(data) {
                        Swal.close();
                        if (data.error) {
                            swalError(data.message, "Hapus Gagal !!");
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