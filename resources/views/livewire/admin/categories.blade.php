<div>
    @if(session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Data Kategori</h3>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" wire:navigate>
                    <i class="bi bi-plus-circle"></i> Tambah Kategori
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->nama }}</td>
                            <td>{{ $category->deskripsi }}</td>
                            <td>
                                <!-- Tombol Edit tetap jalan -->
                               <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-success btn-sm" wire:navigate>
                                    Edit
                                </a>

                                <!-- Tombol Hapus baru -->
                                <button class="btn btn-danger btn-sm"
                                        wire:click="confirmDelete({{ $category->id }})">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- SweetAlert -->
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                document.addEventListener('livewire:initialized', () => {
                    window.addEventListener('swal-delete', event => {
                        Swal.fire({
                            title: "Apakah kamu yakin ?",
                            text: "kamu ingin menghapus kategori ini!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Ya, Hapus!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Panggil method Livewire deleteConfirmed dengan parameter ID
                                Livewire.dispatch('deleteConfirmed', { id: event.detail.id });
                            }
                        });
                    });

                    
                });
                </script>


            </div>
        </div>
    </section>
</div>
