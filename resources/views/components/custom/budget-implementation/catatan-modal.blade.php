<div class="modal fade c-modal-bg" id="catatanModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
    aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Catatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-catatan" action="" method="POST">
                    @csrf
                    @method('post')
                    <input id="catatan_activity" name="activity_id" hidden>
                    <input id="catatan_id" name="catatan_id" hidden>
                    {{-- <div class="mb-4 row"> --}}
                    {{-- <label for="selectTypeReceipt" class="col-sm-2 col-form-label">Jenis Kuitansi</label> --}}
                    {{-- <div class="col-sm-8"> --}}
                    <textarea class="form-control" id="catatan_description" name="catatan_description"></textarea>
                    {{-- <select name="type" class="form-select" id="selectTypeReceipt">
                                <option selected disabled value="">Pilih Jenis Kuitansi...</option>
                                <option value="direct">Pembayaran Langsung</option>
                                <option value="treasurer">Pembayaran Langsung (Bendahara)</option>
                            </select> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}

                    <button id="submitFormedit" class="btn btn-warning text-center align-items-center mt-2 py-auto"
                        type="submit">
                        <span class="icon-name">Edit</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
