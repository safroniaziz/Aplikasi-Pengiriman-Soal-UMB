<div class="modal fade" id="uploadSoalModal" tabindex="-1" aria-labelledby="uploadKopSoalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadSoalModalLabel">Upload Soal Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formUploadSoal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="ujian_id" name="ujian_id">
                    <div class="mb-3">
                        <label for="judul_soal" class="form-label">Judul Soal</label>
                        <input type="text" class="form-control" id="judul_soal" name="judul_soal" placeholder="Masukkan nama file" required>
                    </div>
                    <div class="mb-3">
                        <label for="file_kop_soal" class="form-label">Upload Kop Soal</label>
                        <input type="file" class="form-control" id="file_kop_soal" name="file_kop_soal" accept=".pdf" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitFormUpload()">Upload</button>
            </div>
        </div>
    </div>
</div>
