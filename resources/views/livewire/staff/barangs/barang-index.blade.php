@section('title', 'List Barang')

<div>
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Barang</h5>
                <div class="input-group w-auto">
                    <span class="input-group-text bg-light">
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

            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table bg-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Stok Minimal</th>
                                <th>Satuan</th>
                                <th>Harga Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangs as $index => $barang)
                                <tr>
                                    <td>{{ $barangs->firstItem() + $index }}</td>
                                    <td>{{ $barang->nama }}</td>
                                    <td>{{ $barang->category->nama ?? '-' }}</td>
                                    <td class="{{ $barang->stok <= $barang->stok_minimal ? 'text-danger fw-bold' : '' }}">
                                        {{ $barang->stok }}
                                    </td>
                                    <td>{{ $barang->stok_minimal }}</td>
                                    <td>{{ $barang->satuan }}</td>
                                    <td>Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
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
                </div>

                <div class=" mt-3">
                    {{ $barangs->links() }}
                </div>

            </div>
        </div>
    </section>
    <style>
        thead.bg-primary th {
            color: #fff !important;
        }

    </style>
</div>
