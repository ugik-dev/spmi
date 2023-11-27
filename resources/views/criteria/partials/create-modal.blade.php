<!-- Create Criterion Modal -->
<div class="modal fade" id="createCriterionModal" tabindex="-1" aria-labelledby="createCriterionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCriterionModalLabel">Tambah Kriteria Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="create-criterion-form" action="{{ route('criteria.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="criterion-level">Level Kriteria</label>
                        <select class="form-control" id="criterion-level" name="level">
                            <option value="">Pilih Level</option>
                            @if ($levels['min_level'] == null && $levels['max_level'] == null)
                                <!-- No data in criteria table, show only Level 1 -->
                                <option value="1">Level 1</option>
                            @else
                                <!-- Generate options based on min and max levels -->
                                @for ($i = $levels['min_level']; $i <= $levels['max_level']; $i++)
                                    <option value="{{ $i }}">Level {{ $i }}</option>
                                @endfor
                            @endif
                        </select>
                    </div>
                    <div class="form-group d-none parent-criterion-group">
                        <label for="criterion-parent">Kriteria Induk</label>
                        <select id="criterion-parent" class="form-control" name="parent">
                            <option value="">Pilih Kriteria Induk</option>
                        </select>
                    </div>
                    <!-- Row for inline fields -->
                    <div class="form-row">
                        <!-- Kode Kriteria Induk -->
                        <div class="form-group col-md-3 d-none">
                            <label for="parent-criterion-code">Kode Kriteria Induk</label>
                            <input type="text" id="parent-criterion-code" name="parent_code" class="form-control"
                                disabled readonly>
                        </div>
                        <!-- Kode Kriteria -->
                        <div class="form-group col-md-3">
                            <label for="criterion-code">Kode Kriteria</label>
                            <input type="text" id="criterion-code" name="code" class="form-control">
                        </div>

                        <!-- Nama Kriteria -->
                        <div class="form-group col-md-6">
                            <label for="criterion-name">Nama Kriteria</label>
                            <input type="text" id="criterion-name" name="name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
