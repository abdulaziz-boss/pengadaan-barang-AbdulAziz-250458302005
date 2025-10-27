<div>
    <div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h3>Edit Kategori</h3>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="update">
                    <div class="mb-3">
                        <label>Nama Kategori</label>
                        <input type="text" wire:model="nama" class="form-control">
                        @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea wire:model="deskripsi" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.categories') }}" class="btn btn-danger" wire:navigate>Kembali</a>
                </form>
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                window.addEventListener('swal', event => {
                                    Swal.fire({
                                        title: "Good job!",
                                        text: "Kategori berhasil diedit!",
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then(() => {
                                        // Redirect setelah klik OK
                                        window.location.href = "{{ route('admin.categories') }}";
                                    });
                                });
                </script>
            </div>
        </div>
    </section>
</div>

</div>
