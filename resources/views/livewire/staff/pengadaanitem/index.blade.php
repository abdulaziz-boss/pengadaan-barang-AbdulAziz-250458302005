@section('title', 'Pengajuan Pengadaan Barang')

<div>
    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Pengajuan Pengadaan Barang</h4>
            </div>

            <div class="card-body">
                {{-- Pesan sukses / error dengan auto-hide --}}
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="flash-message">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="flash-message">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Form utama --}}
                <form wire:submit.prevent="save" class="form">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-bold">🛒 Daftar Barang Pengadaan</h6>
                            <hr>
                        </div>

                        {{-- Tabel barang --}}
                        <div class="table-responsive">
                            <div class="col-12">
                                <table class="table align-middle">
                                    <thead class="bg-primary text-white" style="color: white !important;">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Harga Satuan</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <select wire:model="items.{{ $index }}.barang_id"
                                                            wire:change="updateItem({{ $index }})"
                                                            class="form-select">
                                                        <option value="">-- Pilih Barang --</option>
                                                        @foreach ($barangList as $barang)
                                                            <option value="{{ $barang->id }}">
                                                                {{ $barang->nama }} ({{ $barang->category->nama ?? '-' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error("items.$index.barang_id")
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </td>

                                                <td>
                                                    <input type="number" min="1"
                                                        wire:model="items.{{ $index }}.jumlah"
                                                        wire:input="updateItem({{ $index }})"
                                                        class="form-control" style="width: 100px;">
                                                    @error("items.$index.jumlah")
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </td>

                                                <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                            wire:click="removeItem({{ $index }})"
                                                            @if(count($items) == 1) disabled @endif>
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="button" wire:click="addItem" class="btn btn-primary btn-sm mt-2">
                                    <i class="bi bi-plus-circle"></i> Tambah Barang
                                </button>
                            </div>
                        </div>
                        {{-- Total harga --}}
                        <div class="col-12 mt-4 text-end">
                            <h5>Total Harga: <span class="fw-bold text-primary">
                                Rp {{ number_format($totalHarga, 0, ',', '.') }}
                            </span></h5>
                        </div>

                        <hr class="mt-3">

                        {{-- Pilih mode barang --}}
                        <div class="col-md-6 mt-3">
                            <label>Pilih Mode Barang</label>
                            <select wire:model.live="modeBarang" class="form-select">
                                <option value="pilih">Pilih barang yang sudah ada</option>
                                <option value="baru">Tambah barang baru</option>
                            </select>
                        </div>

                        {{-- Jika buat barang baru --}}
                        @if ($modeBarang === 'baru')
                            <div class="col-12 mt-3">
                                <h6 class="fw-bold">🧩 Tambah Barang Baru</h6>
                                <hr>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label>Nama Barang</label>
                                <input type="text" wire:model="newBarang.nama" class="form-control"
                                       placeholder="Masukkan nama barang baru">
                                @error('newBarang.nama')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label>Pilih Mode Kategori</label>
                                <select wire:model="modeKategori" class="form-select">
                                    <option value="pilih">Pilih kategori yang sudah ada</option>
                                    <option value="baru">Buat kategori baru</option>
                                </select>
                            </div>

                            {{-- Jika pilih kategori lama --}}
                            @if ($modeKategori === 'pilih')
                                <div class="col-md-6 mt-2">
                                    <label>Pilih Kategori</label>
                                    <select wire:model="newBarang.category_id" class="form-select">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categoryList as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('newBarang.category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            {{-- Jika buat kategori baru --}}
                            @if ($modeKategori === 'baru')
                                <div class="col-md-6 mt-2">
                                    <label>Nama Kategori Baru</label>
                                    <input type="text" wire:model="newCategory.nama" class="form-control"
                                           placeholder="Masukkan nama kategori baru">
                                    @error('newCategory.nama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label>Deskripsi Kategori</label>
                                    <textarea wire:model="newCategory.deskripsi" class="form-control"
                                              placeholder="Masukkan deskripsi kategori"></textarea>
                                </div>
                            @endif

                            <div class="col-md-6 mt-2">
                                <label>Harga Satuan</label>
                                <input type="number" wire:model="newBarang.harga_satuan" class="form-control"
                                       placeholder="Masukkan harga satuan">
                                @error('newBarang.harga_satuan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label>Stok Minimal</label>
                                <input type="number" wire:model="newBarang.stok_minimal" class="form-control"
                                       placeholder="Masukkan stok minimal">
                                @error('newBarang.stok_minimal')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label>Satuan</label>
                                <input type="text" wire:model="newBarang.satuan" class="form-control"
                                       placeholder="Contoh: pcs, liter, kg">
                                @error('newBarang.satuan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label>Deskripsi Barang</label>
                                <textarea wire:model="newBarang.deskripsi" class="form-control"
                                          placeholder="Deskripsi barang"></textarea>
                            </div>

                            <div class="col-12 d-flex justify-content-end mt-3">
                                <button type="button" wire:click="tambahBarang" class="btn btn-success">
                                    <i class="bi bi-plus-circle"></i> Simpan Barang Baru
                                </button>
                            </div>
                        @endif

                        {{-- Submit --}}
                        <div class="col-12 d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-check-circle"></i> Ajukan Pengadaan
                            </button>
                            <a href="{{ route('staff.pengadaanitems.index') }}" class="btn btn-danger" wire:navigate>
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

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

        /* Animasi fade out untuk flash message */
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        .alert.fade-out {
            animation: fadeOut 0.5s ease-out forwards;
        }
    </style>
</div>

{{-- Script untuk auto-hide dan refresh --}}
@push('scripts')
<script>
document.addEventListener('livewire:init', () => {
    // Function untuk handle flash message
    function handleFlashMessage() {
        const flashMessage = document.getElementById('flash-message');

        if (flashMessage) {
            // Setelah 1.5 detik, tambahkan animasi fade out
            setTimeout(() => {
                flashMessage.classList.add('fade-out');

                // Setelah animasi selesai (0.5 detik), refresh halaman
                setTimeout(() => {
                    window.location.href = '{{ route("staff.pengadaanitems.index") }}';
                }, 500);
            }, 1500);
        }
    }

    // Jalankan saat halaman load
    handleFlashMessage();

    // Listen ke event trigger-refresh dari Livewire
    Livewire.on('trigger-refresh', () => {
        // Tunggu sebentar agar session flash ter-render dulu
        setTimeout(() => {
            handleFlashMessage();
        }, 100);
    });
});
</script>
@endpush
