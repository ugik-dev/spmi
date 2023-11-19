@extends('template.BaseView')
@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Indikator</h6>
            </div>
            <div class="card-body">
                <form action="/indikator/put/{{ $i->id }}" method="post" id="form_indikator">

                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Level 1</label>
                            <select class="form-control" name="l1_id" id="l1" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Level 2</label>
                            <select class="form-control" name="l2_id" id="l2">
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Level 3</label>
                            <select class="form-control" name="l3_id" id="l3">
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Level 4</label>
                            <select class="form-control" name="l4_id" id="l4">
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Bobot</label>
                            <input id="text" class="form-control" name="bobot" value="{!! $i->bobot !!}">
                        </div>
                        <div class="form-group">
                            <label>Indikator</label>
                            <textarea id="name" class="form-control" name="dec">{!! $i->dec !!}</textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="{{ URL::previous() }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">Save</button>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        start_search()
        var indikator = {
            'form': $('#form_indikator'),
            'l1': $('#form_indikator').find('#l1'),
            'l2': $('#form_indikator').find('#l2'),
            'l3': $('#form_indikator').find('#l3'),
            'l4': $('#form_indikator').find('#l4'),
            'dec': $('#form_indikator').find('#dec'),
        }



        function start_search() {
            $.ajax({
                type: 'Get',
                url: '<?= url('search-select-lam') ?>',
                data: {
                    'jenjang': <?= $i['jenjang_id'] ?>,
                    'lembaga': <?= $i['lembaga_id'] ?>,
                },
                cache: false,
                success: function(msg) {
                    $("#l1").html(msg);
                    <?php if (!empty($i->l1)) { ?>

                        // var $newOption = $("<option selected='selected'></option>").val('').text("The text")
                        // indikator.l1.append($newOption).trigger('change');
                        indikator.l1.val(<?= $i->l1->id ?>).trigger('change');
                    <?php } ?>
                }
            });
        }

        indikator.l1.change(function() {
            var l1_id = $("#l1").val();
            $.ajax({
                type: 'GET',
                url: '<?= url('search-select-lam') ?>',
                data: 'parent=' + l1_id,
                cache: false,
                success: function(msg) {
                    $("#l2").html(msg);
                    <?php if (!empty($i->l2)) { ?>
                        indikator.l2.val(<?= $i->l2->id ?>).trigger('change');
                    <?php } ?>
                }
            });
        });

        $("#l2").change(function() {
            var l2_id = $("#l2").val();
            $.ajax({
                type: 'GET',
                url: '<?= url('search-select-lam') ?>',
                data: 'parent=' + l2_id,
                cache: false,
                success: function(msg) {
                    $("#l3").html(msg);
                    <?php if (!empty($i->l3)) { ?>
                        indikator.l3.val(<?= $i->l3->id ?>).trigger('change');
                    <?php } ?>

                }
            });
        });

        $("#l3").change(function() {
            var l3_id = $("#l3").val();
            $.ajax({
                type: 'GET',
                url: '<?= url('search-select-lam') ?>',
                data: 'parent=' + l3_id,
                cache: false,
                success: function(msg) {
                    $("#l4").html(msg);
                    <?php if (!empty($i->l4)) { ?>
                        indikator.l4.val(<?= $i->l4->id ?>).trigger('change');
                    <?php } ?>
                }
            });
        });



    });
</script>
@endsection