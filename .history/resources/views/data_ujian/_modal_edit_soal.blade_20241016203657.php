<div class="modal fade" id="editSoalModal" tabindex="-1" aria-labelledby="editSoalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSoalModalLabel">Edit Soal Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditKopSoal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_ujian_id" name="ujian_id">
                    <div class="mb-3">
                        <label for="edit_judul_soal" class="form-label">Nama File</label>
                        <input type="text" class="form-control" id="edit_judul_soal" name="judul_soal" placeholder="Masukkan nama file" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_file_soal" class="form-label">Upload Soal Baru</label>
                        <input type="file" class="form-control" id="edit_file_soal" name="file_soal" accept=".pdf">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="submitEditFormSoal()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
