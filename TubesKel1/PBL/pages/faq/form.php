<div class="modal fade modal-md" tabindex="-1" id="modal_form">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form id="form_admin">
                    <div class="col-5 row">
                        <input type="hidden" id="id" name="id">
                        <label class="required-label mb-1">Pertanyaan</label>
                        <div class="form-group mb-2">
                            <div class="form-line">
                                <input type="text" class="form-control" id="pertanyaan" name="pertanyaan" required />
                            </div>
                        </div>
                        <label class="required-label mb-1">Jawaban</label>
                        <div class="form-group mb-3">
                            <div class="form-line">
                                <textarea class="form-control" id="jawaban" name="jawaban" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" onclick="save()">Simpan</button>
            </div>
        </div>
    </div>
</div>