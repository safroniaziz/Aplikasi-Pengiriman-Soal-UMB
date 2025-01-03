<div class="modal fade" id="editKopSoalModal" tabindex="-1" aria-labelledby="editKopSoalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKopSoalModalLabel">Edit template Soal Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditKopSoal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_ujian_kop_id" name="ujian_id">
                    <div class="mb-3">
                        <label for="edit_nama_file" class="form-label">Nama File</label>
                        <input type="text" class="form-control" id="edit_nama_file" name="nama_file" placeholder="Masukkan nama file" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_file_kop_soal" class="form-label">Upload template Soal Baru</label>
                        <input type="file" class="form-control" id="edit_file_kop_soal" name="file_kop_soal" accept=".pdf">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="submitEditKopSoalForm()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
