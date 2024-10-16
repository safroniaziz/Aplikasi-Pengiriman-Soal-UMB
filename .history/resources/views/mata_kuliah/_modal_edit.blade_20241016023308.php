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
                    <input type="hidden" id="mata_kuliah_id_id">
                    <div class="mb-3">
                        <label for="kode_mata_kuliah" class="form-label">Kode Mata Kuliah</label>
                        <input type="text" class="form-control" id="edit_kode_mata_kuliah" name="kode_mata_kuliah" placeholder="Masukkan Kode Mata Kuliah" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_mata_kuliah" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" id="edit_nama_mata_kuliah" name="nama_mata_kuliah" placeholder="Masukkan nama mata kuliah" required>
                    </div>

                    <div class="mb-3">
                        <label for="prodi_id" class="form-label">Program Studi</label>
                        <select class="form-control" id="edit_prodi_id" name="prodi_id" required>
                            <option value="" disabled selected>Pilih prodi</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>
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
            url: "{{ route('mataKuliah.update', ':mataKuliah') }}".replace(':mataKuliah', id),
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
