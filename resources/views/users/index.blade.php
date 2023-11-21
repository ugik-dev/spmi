@extends('template.BaseView')
@push('styles')
<style>
  .field-icon {
    cursor: pointer;
    position: absolute;
    right: 2%;
    z-index: 10;
  }
</style>
@endpush
@section('content')
<div class="row">
  <div class="col">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>
      </div>
      <div class="card-body">
        {{-- <a class="btn btn-primary mb-3" href="{{ route('tambah') }}"><i class="fa fa-plus"></i> Tambah Pengguna</a>
        --}}
        @include('partials.session')
        <div class="table-responsive">
          <table class="table table-bordered" id="users-datatable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Prodi</th>
                <th width="150px">Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Prodi</th>
                <th width="150px">Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td style="width: 200px">
                  @foreach ($user->roles as $role)
                  <span class="badge badge-info text-wrap p-2 m-1">{{ $role->name }}</span>
                  @endforeach
                </td>
                <td>{{ $user->prodi?->name }}</td>
                <td width="150px" class="d-flex justify-content-center">
                  <button type="button" class="btn btn-warning btn-edit mr-1 mb-1 mb-md-0" data-user="{{ $user }}"
                    data-toggle="modal" data-target="#editModal">Edit</button>
                  <form action="{{ route('users.delete',$user->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn">Hapus</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div style="min-width:60vw;" class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Data Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit-form" action="" method="POST">
          @csrf
          @method('PATCH')
          <div class="form-group">
            <label for="user-name">Nama</label>
            <input type="text" id="user-name" name="name" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="">Role</label>
            <select class="form-control" id="user-role" name="role">
              <option value="">Pilih Role</option>
              @foreach ($roles as $role)
              <option value="{{ $role }}">{{ ucfirst($role) }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="user-email">Email</label>
            <input type="email" id="user-email" name="email" class="form-control" required>
          </div>

          <div class="form-group d-flex align-items-center">
            <input type="password" class="form-control form-control-user" id="user-password" placeholder="Password"
              name="password">
            <span toggle="#user-password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
          </div>
          <div class="form-group">
            <button class="btn-warning btn w-25" type="submit">Simpan</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(".toggle-password").click(function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
          input.attr("type", "text");
      } else {
          input.attr("type", "password");
      }
  });
</script>
<script>
  $('#users-datatable').DataTable({
        "order": [0, 'asc']
    });
  $('#editModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var userData = button.data('user');

    var formEdit = $('#edit-form');
    var actionUrl = '/edit-pengguna/' + userData.id;

    // Fill the inputs inside edit form
    formEdit.attr("action", actionUrl);
    $("#user-name").val(userData.name)
    $("#user-email").val(userData.email)
    $("#user-role").val(userData.roles?.[0]?.name || '');
});

  $('#editModal').on('hidden.bs.modal', function (event) {
  // do something...
})

</script>
@endpush