<!-- Modal Edit Prodi -->
<div class="modal fade" tabindex="-1" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Dosen</h5>
                <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-2x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <input type="hidden" id="dosen_id">
                    <div class="mb-3">
                        <label for="kode_user" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="kode_user" name="kode_user" placeholder="Masukkan kode prodi" required>
                    </div>

                    <div class="mb-3">
                        <label for="nidn" class="form-label">NIDN</label>
                        <input type="text" class="form-control" id="nidn" name="nidn" placeholder="Masukkan kode prodi" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama prodi" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan nama prodi" required>
                    </div>

                    <div class="mb-3">
                        <label for="jenjang" class="form-label">Program Studi</label>
                        <select class="form-control" id="jenjang" name="jenjang" required>
                            <option value="" disabled selected>Pilih jenjang prodi</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>
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
        var id = $('#dosen_id').val();
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
