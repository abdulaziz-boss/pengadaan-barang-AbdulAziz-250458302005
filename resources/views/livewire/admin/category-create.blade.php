<div>
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Tambah Kategori</h4>
                        <a href="{{ route('admin.categories') }}" class="btn btn-danger" wire:navigate>Kembali</a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form wire:submit.prevent="save" class="form">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="nama">Nama Kategori</label>
                                            <input type="text" id="nama" class="form-control" placeholder="Nama Kategori" wire:model="nama">
                                            @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi</label>
                                            <input type="text" id="deskripsi" class="form-control" placeholder="Deskripsi" wire:model="deskripsi">
                                            @error('deskripsi') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <button type="reset" class="btn btn-success me-1 mb-1">Reset</button>
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                    </div>
                                </div>
                            </form>

                            <!-- SCRIPT SWEETALERT -->
                            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                window.addEventListener('swal', event => {
                                    Swal.fire({
                                        title: "Good job!",
                                        text: "Kategori berhasil ditambahkan!",
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then(() => {
                                        // Redirect setelah klik OK
                                        window.location.href = "{{ route('admin.categories') }}";
                                    });
                                });
                            </script>
                            </script>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
