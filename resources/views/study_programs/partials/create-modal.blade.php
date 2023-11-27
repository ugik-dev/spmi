<!-- Create Study Program Modal -->
<div class="modal fade" id="createStudyProgramModal" tabindex="-1" aria-labelledby="createStudyProgramModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createStudyProgramModalLabel">Tambah Program Studi (Prodi)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('programs.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="studyProgram-name">Nama Prodi</label>
                        <input type="text" id="studyProgram-name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="studyProgram-code">Kode</label>
                        <input type="text" id="studyProgram-code" name="code" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Jenjang</label>
                        <select class="form-control" id="studyProgram-degree" name="degree">
                            <option value="">Pilih Jenjang</option>
                            @foreach ($degrees as $degree)
                                <option value="{{ $degree->id }}">{{ ucfirst($degree->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Fakultas</label>
                        <select class="form-control" id="studyProgram-faculty" name="faculty">
                            <option value="">Pilih Fakultas</option>
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}">{{ ucfirst($faculty->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="studyProgram-vision">Visi</label>
                        <div id="create-vision-container">

                        </div>
                        <button type="button" class="btn btn-outline-primary" id="add-create-vision">Tambahkan
                            Visi</button>
                    </div>
                    <div class="form-group">
                        <label for="studyProgram-mission">Misi</label>
                        <textarea id="studyProgram-mission" name="mission" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="studyProgram-description">Deskripsi</label>
                        <textarea id="studyProgram-description" name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
