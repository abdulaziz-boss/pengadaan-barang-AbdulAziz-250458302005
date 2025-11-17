@section('title', 'Data Categories')

<div>
    @if(session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <section class="section">
       <div class="card shadow-sm rounded-4 overflow-hidden ">
            <div class="card-header d-flex justify-content-between align-items-center ">
                <h4 class="card-title mb-0 ">Data Kategori</h4>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" wire:navigate>
                    <i class="bi bi-plus-circle"></i> Tambah Kategori
                </a>
            </div>

            <div class="card-body">

                <table class="table align-middle">
                    <thead class="bg-primary ">
                        <tr>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Barang</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->nama }}</td>
                            <td>{{ $category->deskripsi }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $category->barangs->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-success btn-sm" wire:navigate>
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <button class="btn btn-danger btn-sm"
                                        wire:click="confirmDelete({{ $category->id }})">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada kategori yang tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- SweetAlert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            window.addEventListener('swal-delete', event => {
                Swal.fire({
                    title: "Apakah kamu yakin?",
                    text: "Data kategori ini akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteConfirmed', { id: event.detail.id });
                    }
                });
            });
        });
    </script>

    <style>
        thead.bg-primary th {
            color: #fff !important;
        }

    </style>
</div>

