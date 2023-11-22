<!-- Edit Faculty Modal -->
<div class="modal fade" id="editFacultyModal" tabindex="-1" aria-labelledby="editFacultyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFacultyModalLabel">Edit Fakultas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-faculty-form" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="edit-faculty-id" name="id">
                    <div class="form-group">
                        <label for="edit-faculty-name">Nama Fakultas</label>
                        <input type="text" id="edit-faculty-name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-faculty-abbr">Singkatan</label>
                        <input type="text" id="edit-faculty-abbr" name="abbr" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-faculty-vision">Visi</label>
                        <div id="edit-vision-container">
                            <!-- Vision inputs will be populated here -->
                        </div>
                        <button type="button" class="btn btn-outline-primary" id="add-edit-vision">Tambahkan
                            Visi</button>

                    </div>
                    <div class="form-group">
                        <label for="edit-faculty-mission">Misi</label>
                        <textarea id="edit-faculty-mission" name="mission" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-faculty-description">Deskripsi</label>
                        <textarea id="edit-faculty-description" name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
