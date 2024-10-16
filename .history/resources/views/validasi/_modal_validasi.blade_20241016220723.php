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
                <!-- Form input nama_prodi -->
                <form id="formValidasi">
                    @csrf

                    <div class="mb-3">
                        <label for="pengupload_id" class="form-label">Dosen Pengupload Soal</label>
                        <select class="form-control" id="pengupload_id" name="pengupload_id" required>
                            <option value="" disabled selected>Pilih dosen</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_dilaksanakan" class="form-label">Tanggal Dilaksanakan</label>
                        <input type="date" class="form-control" id="tanggal_dilaksanakan" name="tanggal_dilaksanakan" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                        <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
                    </div>
                    <div class="mb-3">
                        <label for="ruangan" class="form-label">Ruangan</label>
                        <input type="text" class="form-control" id="ruangan" name="ruangan" placeholder="Masukkan nama ruangan" required>
                    </div>
                    <div class="mb-3">
                        <label for="batas_waktu_upload_soal" class="form-label">Batas Waktu Upload Soal</label>
                        <input type="datetime-local" class="form-control" id="batas_waktu_upload_soal" name="batas_waktu_upload_soal" required>
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
