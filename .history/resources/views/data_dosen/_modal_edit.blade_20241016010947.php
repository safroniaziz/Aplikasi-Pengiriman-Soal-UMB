<!-- Modal Edit Prodi -->
<div class="modal fade" tabindex="-1" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Program Studi</h5>
                <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-2x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <input type="hidden" id="prodi_id">
                    <div class="mb-3">
                        <label for="kode_dosen" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="edit_kode_dosen" name="kode_dosen" placeholder="Masukkan kpde prodi" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                        <input type="text" class="form-control" id="edit_nama_prodi" name="nama_prodi" placeholder="Masukkan nama prodi" required>
                    </div>

                    <div class="mb-3">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <select class="form-control" id="edit_jenjang" name="jenjang" required>
                            <option value="" disabled selected>Pilih jenjang prodi</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="visi" class="form-label">Visi Program Studi</label>
                        <textarea class="form-control" id="edit_visi" name="visi" rows="5" placeholder="Masukkan visi prodi" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="misi" class="form-label">Misi Program Studi</label>
                        <textarea class="form-control" id="edit_misi" name="misi" rows="5" placeholder="Masukkan misi prodi" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="updateProdi()">Update</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateProdi() {
        var id = $('#prodi_id').val();
        var formData = new FormData($('#editForm')[0]);
        formData.append('_method', 'PATCH');

        $.ajax({
            url: "{{ route('prodi.update', ':programStudi') }}".replace(':programStudi', id),
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
                var errorMessage = "Terjadi kesalahan saat mengupdate program studi.";
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
