<div class="modal fade" tabindex="-1" id="tambahModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mata Kuliah</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <!-- Form input nama_prodi -->
                <form id="formDosen">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_mata_kuliah" class="form-label">Kode Mata Kuliah</label>
                        <input type="text" class="form-control" id="kode_mata_kuliah" name="kode_mata_kuliah" placeholder="Masukkan Kode Mata Kuliah" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_mata_kuliah" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" id="nama_mata_kuliah" name="nama_mata_kuliah" placeholder="Masukkan nama mata kuliah" required>
                    </div>

                    <div class="mb-3">
                        <label for="prodi_id" class="form-label">Program Studi</label>
                        <select class="form-control" id="prodi_id" name="prodi_id" required>
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
                <button type="button" class="btn btn-primary btn-sm" onclick="submitForm()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    function submitForm() {
        var formData = new FormData(document.getElementById('formDosen'));
        $.ajax({
            url: "{{ route('mataKuliah.post') }}", // Route tujuan
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val() // Token CSRF
            },
            success: function(response) {
                // Jika sukses, tampilkan SweetAlert
                Swal.fire({
                    title: "Good job!",
                    text: "Data berhasil disimpan!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(() => {
                    // Tutup modal setelah klik "OK"
                    $('#tambahModal').modal('hide');
                    // Reload halaman setelah modal ditutup
                    location.reload();
                });
            },

            error: function(xhr) {
                // Tangkap error dari response
                let errorMessage = "Terjadi kesalahan saat menyimpan data!";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                // Jika error, tampilkan SweetAlert dengan pesan error
                Swal.fire({
                    title: "Error!",
                    text: errorMessage,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    }
                });
            }
        });
    }
</script>
