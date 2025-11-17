<div>
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Pengadaan Barang</h5>

            <div class="input-group w-auto">
                <input wire:model.debounce.500ms="search"
                       type="text"
                       class="form-control"
                       placeholder="Cari nama barang atau pengaju...">
                <span class="input-group-text bg-light">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>

        <div class="card-body">
            {{-- Alert --}}
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session()->has('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('danger') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Pengadaan</th>
                            <th>Pengaju</th>
                            <th>Daftar Barang</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengadaans as $index => $pengadaan)
                            <tr>
                                <td>{{ $pengadaans->firstItem() + $index }}</td>
                                <td><strong>{{ $pengadaan->kode_pengadaan }}</strong></td>
                                <td>{{ $pengadaan->pengaju->name ?? '-' }}</td>
                                <td class="text-start">
                                    <ul class="mb-0">
                                        @foreach ($pengadaan->items as $item)
                                            <li>
                                                {{ $item->barang->nama ?? 'Barang tidak ditemukan' }}
                                                — <small>{{ $item->jumlah }} {{ $item->barang->satuan ?? '' }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>Rp {{ number_format($pengadaan->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @switch($pengadaan->status)
                                        @case('menunggu')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                            @break
                                        @case('disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                            @break
                                        @case('ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">-</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if ($pengadaan->status == 'menunggu')
                                        <button wire:click="setujui({{ $pengadaan->id }})"
                                                class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Setujui
                                        </button>

                                        <button wire:click="tolak({{ $pengadaan->id }})"
                                                class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-circle"></i> Tolak
                                        </button>
                                    @else
                                        <em>-</em>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Tidak ada data pengadaan ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class=" mt-3">
                {{ $pengadaans->links() }}
            </div>
        </div>
    </div>
</div>
