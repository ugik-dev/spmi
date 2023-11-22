<!-- Create Faculty Modal -->
<div class="modal fade" id="createFacultyModal" tabindex="-1" aria-labelledby="createFacultyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createFacultyModalLabel">Tambah Fakultas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('faculties.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="faculty-name">Nama Fakultas</label>
                        <input type="text" id="faculty-name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="faculty-abbr">Singkatan</label>
                        <input type="text" id="faculty-abbr" name="abbr" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="faculty-vision">Visi</label>
                        <div id="create-vision-container">

                        </div>
                        <button type="button" class="btn btn-outline-primary" id="add-create-vision">Tambahkan
                            Visi</button>
                    </div>
                    <div class="form-group">
                        <label for="faculty-mission">Misi</label>
                        <textarea id="faculty-mission" name="mission" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="faculty-description">Deskripsi</label>
                        <textarea id="faculty-description" name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
