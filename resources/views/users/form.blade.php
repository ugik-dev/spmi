@extends('template.BaseView')
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $edit ? 'Edit' : 'Tambah' }} User</h4>
                <form action="{{ $edit ? '/users/put/' . $i->id : '/users/store' }}" id="form_user" method="post">
                    @csrf
                    @if ($edit)
                    @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="">Nama User</label>
                        <input name="id" id="id" value="" hidden>
                        <input type="text" name="name" id="name" class="form-control" value="" aria-describedby="helpId" required>
                    </div>
                    <div class="form-group {{ auth()->user()->role == 'Prodi' ? 'd-none' : '' }}">
                        <label for="">Role</label>
                        <select type="" name="role" id='role' class="form-control" aria-describedby="helpId" required>
                            <option value="-">Pilih Role</option>
                            <option value="Prodi">Prodi</option>
                            <option value="Auditor">Auditor</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Prodi</label>
                        <select disabled type="" name="prodi_kode" id='prodi_kode' class="form-control" aria-describedby="helpId">
                            <option value=""></option>
                            @foreach ($f as $fak)
                            <optgroup label="{{ $fak->nama }}">
                                @foreach ($fak->prodi as $prod)
                                <option value="{{ $prod->kode }}">{{ $prod->name }}
                                    ({{ $prod->kode }})
                                </option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" id="email" class="form-control" aria-describedby="helpId" {{ Auth::user()->role == 'Prodi' ? 'readonly' : 'required' }}>
                    </div>

                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="text" name="password" class="form-control" aria-describedby="helpId" <?= $edit ? "placeholder='Kosongkan jika tidak diganti'" : 'required' ?>>
                    </div>
                    <div class="form-group">
                        <button class="btn-primary btn-sm" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var FormUser = {
            'self': $('#form_user'),
            'id': $('#form_user').find('#id'),
            'role': $('#form_user').find('#role'),
            'name': $('#form_user').find('#name'),
            'email': $('#form_user').find('#email'),
            'prodi_kode': $('#form_user').find('#prodi_kode'),
            'password': $('#form_user').find('#password'),
        };

        FormUser.role.on('change', function(ev) {
            if (FormUser.role.val() == 'Prodi') {
                FormUser.prodi_kode.prop('disabled', false)
                FormUser.prodi_kode.prop('required', true)
            } else {
                FormUser.prodi_kode.val('-')
                FormUser.prodi_kode.prop('required', false)
                FormUser.prodi_kode.prop('disabled', true)
                FormUser.email.prop('disabled', true)
            }
        })

        <?php if ($edit) { ?>
            FormUser.id.val('<?= $i->id ?>');
            FormUser.name.val('<?= $i->name ?>');
            FormUser.role.val('<?= $i->role ?>');
            // FormUser.role.trigger('change');
            FormUser.email.val('<?= $i->email ?>');
            <?php if ($i->role == 'Prodi') { ?>
                FormUser.prodi_kode.val('<?= $i->prodi_kode ?>');

        <?php }
        } ?>
    })
</script>
@endsection