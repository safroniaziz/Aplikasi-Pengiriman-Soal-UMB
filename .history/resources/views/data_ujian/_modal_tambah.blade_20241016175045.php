<div class="modal fade" tabindex="-1" id="tambahModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Ujian</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <!-- Form input nama_prodi -->
                <form id="formUjian">
                    @csrf
                    <div class="mb-3">
                        <label for="mata_kuliah_id" class="form-label">Mata Kuliah</label>
                        <select class="form-control" id="mata_kuliah_id" name="mata_kuliah_id" required>
                            <option value="" disabled selected>Pilih mata kuliah</option>
                            @foreach ($mataKuliahs as $mataKuliah)
            <option value="{{ $mataKuliah->id }}" data-prodi-id="{{ $mataKuliah->prodi_id }}">{{ $mataKuliah->nama_mata_kuliah }}</option>
        @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dosen_id" class="form-label">Dosen</label>
                        <select class="form-control" id="dosen_id" name="dosen_id" required>
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
                <button type="button" class="btn btn-primary btn-sm" onclick="submitForm()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#mata_kuliah_id').change(function() {
        var mataKuliahId = $(this).val();
        var prodiId = $(this).find(':selected').data('prodi-id'); // Ambil prodi_id dari mata kuliah yang dipilih

        // AJAX request untuk mengambil dosen berdasarkan prodi_id
        $.ajax({
            url: "{{ route('ujian.getDosenByProdi', ':prodi_id') }}".replace(':prodi_id', prodiId),
            method: 'GET',
            success: function(response) {
                // Hapus opsi lama pada dropdown dosen
                $('#dosen_id').empty();
                $('#dosen_id').append('<option value="" disabled selected>Pilih dosen</option>');

                // Tambahkan opsi dosen yang diambil dari server
                $.each(response, function(index, dosen) {
                    $('#dosen_id').append('<option value="'+ dosen.id +'">'+ dosen.nama_lengkap +'</option>');
                });
            },
            error: function(xhr) {
                console.log("Error saat mengambil dosen:", xhr);
            }
        });
    });


    function submitForm() {
        var formData = new FormData(document.getElementById('formUjian'));
        $.ajax({
            url: "{{ route('ujian.post') }}", // Route tujuan
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
