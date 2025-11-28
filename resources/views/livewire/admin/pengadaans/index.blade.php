@section('title', 'List pengadaan')

<div>
    <div class="card shadow-sm rounded-4 overflow-hidden">

        <!-- CARD HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Riwayat Pengadaan (Admin)</h5>

            <div class="d-flex gap-2 align-items-center">

                {{-- Input Search --}}
                <input type="text"
                    wire:model.live.debounce.500ms="search"
                    class="form-control form-control-sm"
                    placeholder="Cari: nama barang / kategori / kode / pengaju"
                    style="width: 320px;">

                {{-- Export Excel --}}
                <button class="btn btn-success btn-sm"
                        wire:click="exportExcel"
                        wire:loading.attr="disabled"
                        @disabled(empty(array_filter($selected)))
                >
                    <span wire:loading.remove wire:target="exportExcel">Excel</span>
                    <span wire:loading wire:target="exportExcel"
                        class="spinner-border spinner-border-sm"></span>
                </button>

                {{-- Export PDF --}}
                <button class="btn btn-secondary btn-sm"
                        wire:click="exportPdf"
                        wire:loading.attr="disabled"
                        @disabled(empty(array_filter($selected)))
                >
                    <span wire:loading.remove wire:target="exportPdf">PDF</span>
                    <span wire:loading wire:target="exportPdf"
                        class="spinner-border spinner-border-sm"></span>
                </button>

                {{-- Delete --}}
                <button class="btn btn-danger btn-sm"
                        onclick="confirmDeleteAdmin()"
                        @disabled(empty(array_filter($selected)))
                >
                    Hapus ({{ count(array_filter($selected)) }})
                </button>
            </div>
        </div>



        <!-- CARD BODY -->
        <div class="table-responsive">
            <div class="card-body">
                <table class="table align-middle mb-0">
                    <thead class="bg-primary text-white" style="color: white !important;">
                        <tr>
                            <th width="50">
                                <input type="checkbox"
                                    wire:model.live="selectPage"
                                    class="form-check-input"
                                    style="cursor: pointer;">
                            </th>
                            <th>Kode</th>
                            <th>Pengaju</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        {{-- Jika selectPage True tapi belum selectAll --}}
                        @if ($selectPage && !$selectAll)
                            <tr>
                                <td colspan="7" class="bg-light p-2">
                                    Kamu memilih <strong>{{ count(array_filter($selected)) }}</strong> data
                                    di halaman ini.

                                    <button wire:click="selectAllAcrossPages"
                                            class="btn btn-link p-0">
                                        Pilih semua ({{ $pengadaans->total() }})
                                    </button>
                                </td>
                            </tr>
                        @endif


                        @forelse ($pengadaans as $p)
                            <tr>
                                <td>
                                    <input type="checkbox"
                                           wire:model.live="selected.{{ $p->id }}"
                                           class="form-check-input"
                                           style="cursor: pointer;">
                                </td>

                                <td>{{ $p->kode_pengadaan }}</td>
                                <td>{{ $p->pengaju->name ?? '-' }}</td>

                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>

                                <td>
                                    @switch($p->status)
                                        @case('disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                            @break
                                        @case('ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                            @break
                                        @case('selesai')
                                            <span class="badge bg-primary">Selesai</span>
                                            @break
                                        @default
                                            <span class="badge bg-warning">{{ ucfirst($p->status) }}</span>
                                    @endswitch
                                </td>

                                <td>{{ $p->tanggal_pengajuan ?? '-' }}</td>

                                <td class="text-center">

                                    <a href="{{ route('admin.pengadaans.show', $p->id) }}"
                                       class="badge bg-info text-decoration-none"
                                       wire:navigate>
                                        Detail
                                    </a>

                                    <button type="button"
                                            wire:click="confirmDelete({{ $p->id }})"
                                            class="badge bg-danger border-0">
                                        Hapus
                                    </button>

                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    Tidak ada data pengadaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-3">
                    {{ $pengadaans->links() }}
                </div>
            </div>
        </div>
    </div>



    <!-- STYLE -->
    <style>
        thead.bg-primary th {
            color: #fff !important;
        }
        .card {
            border-radius: 1rem;
            overflow: hidden;
        }
        .card-header {
            border-bottom: 1px solid #eee;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</div>


<!-- SWEETALERT SCRIPT -->
@push('scripts')
<script>
function confirmDeleteAdmin() {
    Swal.fire({
        title: 'Yakin ingin menghapus data terpilih?',
        text: 'Data tidak bisa dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((r) => {
        if (r.isConfirmed) {
            Livewire.dispatch("deleteConfirmed");
        }
    });
}
</script>
@endpush
