<div class="modal fade" tabindex="-1" id="validasiModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validasi Soal Ujian</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <!-- Form input validasi status dan catatan kaprodi -->
                <form id="formValidasi">
                    @csrf
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Validasi</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="pending">Pending</option>
                            <option value="validated">Validated</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="catatan_kaprodi" class="form-label">Catatan Kaprodi</label>
                        <textarea class="form-control" id="catatan_kaprodi" name="catatan_kaprodi" rows="4" placeholder="Masukkan catatan kaprodi (opsional)"></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="submitValidasi()">Simpan</button>
            </div>
        </div>
    </div>
</div>
