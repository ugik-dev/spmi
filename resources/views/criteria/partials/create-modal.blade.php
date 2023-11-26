<!-- Create Criterion Modal -->
<div class="modal fade" id="createCriterionModal" tabindex="-1" aria-labelledby="createCriterionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCriterionModalLabel">Tambah Kriteria Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('criteria.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="criterion-level">Level Kriteria</label>
                        <select class="form-control" id="criterion-level" name="level">
                            <option value="">Pilih Level</option>
                            <!-- Specify levels as required -->
                            <option value="1">Level 1</option>
                            <option value="2">Level 2</option>
                            <!-- Add more levels if needed -->
                        </select>
                    </div>
                    <div class="form-group d-none" id="parent-criterion-group">
                        <label for="criterion-parent">Kriteria Induk</label>
                        <select type="text" id="criterion-parent" class="form-control" readonly>
                            <input type="hidden" name="parent_id">
                    </div>
                    <div class="form-group">
                        <label for="criterion-code">Kode Kriteria</label>
                        <input type="text" id="criterion-code" name="code" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="criterion-name">Nama Kriteria</label>
                        <input type="text" id="criterion-name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
