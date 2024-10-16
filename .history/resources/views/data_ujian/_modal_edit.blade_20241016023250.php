<!-- Modal Edit Prodi -->
<div class="modal fade" tabindex="-1" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Mata Kuliah</h5>
                <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-2x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <input type="hidden" id="ujian_id" name="ujian_id">
                    <div class="mb-3">
                        <label for="edit_mata_kuliah_id" class="form-label">Mata Kuliah</label>
                        <select class="form-control" id="edit_mata_kuliah_id" name="mata_kuliah_id" required>
                            @foreach ($mataKuliahs as $mataKuliah)
                                <option value="{{ $mataKuliah->id }}">{{ $mataKuliah->nama_mata_kuliah }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_dilaksanakan" class="form-label">Tanggal Dilaksanakan</label>
                        <input type="date" class="form-control" id="edit_tanggal_dilaksanakan" name="tanggal_dilaksanakan" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="time" class="form-control" id="edit_waktu_mulai" name="waktu_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_waktu_selesai" class="form-label">Waktu Selesai</label>
                        <input type="time" class="form-control" id="edit_waktu_selesai" name="waktu_selesai" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_ruangan" class="form-label">Ruangan</label>
                        <input type="text" class="form-control" id="edit_ruangan" name="ruangan" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_batas_waktu_upload_soal" class="form-label">Batas Waktu Upload Soal</label>
                        <input type="datetime-local" class="form-control" id="edit_batas_waktu_upload_soal" name="batas_waktu_upload_soal" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="updateMataKuliah()">Update</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateMataKuliah() {
        var id = $('#mata_kuliah_id_id').val();
        var formData = new FormData($('#editForm')[0]);
        formData.append('_method', 'PATCH');

        $.ajax({
            url: "{{ route('ujian.update', ':mataKuliah') }}".replace(':mataKuliah', id),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    $('#editModal').modal('hide');
                    location.reload();
                });
            },
            error: function(xhr) {
                var errorMessage = "Terjadi kesalahan saat mengupdate mata kuliah.";
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    if (xhr.responseJSON.error) {
                        errorMessage += "\n\nDetail error: " + xhr.responseJSON.error;
                    }
                }
                Swal.fire({
                    title: "Error!",
                    text: errorMessage,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    }
</script>
@endpush
