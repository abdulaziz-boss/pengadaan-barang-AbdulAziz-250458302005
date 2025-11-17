<div>
    @section('title', 'List Kategori')

    <div>
        <section class="section">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Data Kategori </h5>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" wire:model.live="search" class="form-control" placeholder="Cari kategori...">
                            @if($search)
                                <button class="btn btn-outline-danger" wire:click="$set('search', '')">
                                    <i class="bi bi-x"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="bg-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $index => $category)
                                    <tr>
                                        <td>{{ $categories->firstItem() + $index }}</td>
                                        <td>{{ $category->nama }}</td>
                                        <td>{{ $category->deskripsi ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $category->barangs->count() }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            @if($search)
                                                Tidak ada hasil untuk "{{ $search }}"
                                            @else
                                                Belum ada data kategori
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>


    <style>
        thead.bg-primary th {
            color: #fff !important;
        }

    </style>
</div>
