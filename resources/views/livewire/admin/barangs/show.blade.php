@section('title', 'Detail Barang - ' . $nama_barang)

<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">Detail Barang</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.barangs.edit', $barang->id) }}" class="btn btn-warning btn-sm" wire:navigate>
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.barangs.index') }}" class="btn btn-danger   btn-sm" wire:navigate>
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- Informasi Utama --}}
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">Informasi Barang</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nama Barang</strong></td>
                                    <td width="5%">:</td>
                                    <td>{{ $nama_barang }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori</strong></td>
                                    <td>:</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $nama_kategori }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Satuan</strong></td>
                                    <td>:</td>
                                    <td>
                                        <span class="badge bg-info">{{ $satuan }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Harga Satuan</strong></td>
                                    <td>:</td>
                                    <td>
                                        <span class="fw-bold text-success">Rp {{ number_format($harga_satuan, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Informasi Stok --}}
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">Informasi Stok</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Stok Saat Ini</strong></td>
                                    <td width="5%">:</td>
                                    <td>
                                        @if($stok == 0)
                                            <span class="badge bg-danger">Habis</span>
                                        @elseif($stok <= $stok_minimal)
                                            <span class="badge bg-warning">Hampir Habis</span>
                                        @else
                                            <span class="badge bg-success">Aman</span>
                                        @endif
                                        <span class="fw-bold ms-2">{{ $stok }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Stok Minimal</strong></td>
                                    <td>:</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $stok_minimal }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>:</td>
                                    <td>
                                        @if($stok == 0)
                                            <span class="text-danger fw-bold">Stok Habis</span>
                                        @elseif($stok <= $stok_minimal)
                                            <span class="text-warning fw-bold">Perlu Restock</span>
                                        @else
                                            <span class="text-success fw-bold">Stok Tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>



                {{-- Informasi Timestamp --}}
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">Informasi Sistem</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="30%"><strong>Dibuat</strong></td>
                                            <td>:</td>
                                            <td>
                                                {{ $created_at->format('d F Y H:i') }}
                                                <small class="text-muted">({{ $created_at->diffForHumans() }})</small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="30%"><strong>Diperbarui</strong></td>
                                            <td>:</td>
                                            <td>
                                                {{ $updated_at->format('d F Y H:i') }}
                                                <small class="text-muted">({{ $updated_at->diffForHumans() }})</small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
