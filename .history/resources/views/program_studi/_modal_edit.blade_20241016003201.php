<!-- Modal Edit Kategori -->
<div class="modal fade" tabindex="-1" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kategori Anggota</h5>
                <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-2x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <input type="hidden" id="kategori_id">
                    <div class="mb-3">
                        <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                        <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" placeholder="Masukkan nama prodi" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                        <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" placeholder="Masukkan nama prodi" required>
                    </div>

                    <div class="mb-3">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <input type="text" class="form-control" id="jenjang" name="jenjang" placeholder="Masukkan jenjang prodi" required>
                    </div>

                    <div class="mb-3">
                        <label for="visi" class="form-label">Visi Program Studi</label>
                        <textarea class="form-control" id="visi" name="visi" rows="5" placeholder="Masukkan visi prodi" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="misi" class="form-label">Misi Program Studi</label>
                        <textarea class="form-control" id="misi" name="misi" rows="5" placeholder="Masukkan misi prodi" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="updateKategori()">Update</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateKategori() {
        var id = $('#kategori_id').val();
        var formData = new FormData($('#editForm')[0]);
        formData.append('_method', 'PATCH');

        $.ajax({
            url: "{{ route('risalah.kategoriAnggota.update', ':kategoriAnggota') }}".replace(':kategoriAnggota', id),
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
                var errorMessage = "Terjadi kesalahan saat mengupdate kategori.";
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
