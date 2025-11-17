@section('title', 'List Barang')

<div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Data Barang</h5>
            </div>

            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- ========== MODIFIKASI SEARCH BAR & TOMBOL TAMBAH ========== --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input
                                type="text"
                                wire:model.live="search"
                                class="form-control"
                                placeholder="Cari barang, kategori, atau satuan..."
                            >
                            @if($search)
                                <button class="btn btn-outline-danger" wire:click="$set('search', '')" type="button">
                                    <i class="bi bi-x"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('admin.barangs.create') }}" class="btn btn-primary w-65" wire:navigate>
                            <i class="bi bi-plus-circle"></i> Tambah Barang
                        </a>
                    </div>
                </div>
                {{-- ========== END MODIFIKASI ========== --}}

                <table class="table" id="table1">
                    <thead class="bg-primary ">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Stok Minimal</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                            <tr>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->category->nama ?? '-' }}</td>
                                <td class="{{ $barang->stok <= $barang->stok_minimal ? 'text-danger fw-bold' : '' }}">
                                    {{ $barang->stok }}
                                </td>
                                <td>{{ $barang->stok_minimal }}</td>
                                <td>{{ $barang->satuan }}</td>
                                <td>Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.barangs.show', $barang->id) }}" class="badge bg-primary text-decoration-none" wire:navigate>Lihat</a>
                                    <a href="{{ route('admin.barangs.edit', $barang->id) }}" class="badge bg-success text-decoration-none" wire:navigate>Edit</a>
                                    <button wire:click="confirmDelete({{ $barang->id }})" class="badge bg-danger border-0">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    @if($search)
                                        Tidak ada hasil untuk "{{ $search }}"
                                    @else
                                        Belum ada data barang
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>


                {{ $barangs->links() }}
            </div>
        </div>
    </section>
    <style>
        thead.bg-primary th {
            color: #fff !important;
        }

    </style>
</div>
@push('scripts')
<script>
document.addEventListener('livewire:init', () => {
    // Saat event 'show-delete-confirmation' dikirim dari Livewire
    Livewire.on('show-delete-confirmation', (event) => {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data barang yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                // kirim kembali ke Livewire
                Livewire.dispatch('deleteConfirmed', { id: event.id });
            }
        });
    });

    // Setelah dihapus sukses
    Livewire.on('barang-deleted', () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Barang berhasil dihapus!',
            showConfirmButton: false,
            timer: 1500
        });
    });
});
</script>
@endpush


