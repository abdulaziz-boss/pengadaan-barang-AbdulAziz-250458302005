<div>
    <div class="page-content">
        <section class="row">
            {{-- KOLOM KIRI --}}
            <div class="col-12 col-lg-9">
                {{-- CARD STATISTIK --}}
                <div class="row mb-4">
                    @php
                        $stats = [
                                    ['title' => 'Diproses', 'value' => $totalDiproses, 'icon' => 'bi-hourglass-split', 'color' => 'blue'],
                                    ['title' => 'Disetujui', 'value' => $totalDisetujui, 'icon' => 'bi-check-circle', 'color' => 'green'],
                                    ['title' => 'Ditolak', 'value' => $totalDitolak ?? 0, 'icon' => 'bi-x-circle', 'color' => 'red'],
                                    ['title' => 'Selesai', 'value' => $totalSelesai, 'icon' => 'bi-flag', 'color' => 'purple'],
                                ];
                    @endphp

                    @foreach ($stats as $item)
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card shadow-sm border-0 h-100 stats-card">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-3">
                                    <div class="stats-icon {{ $item['color'] }} mb-2">
                                        <i class="bi {{ $item['icon'] }}"></i>
                                    </div>
                                    <h6 class="text-muted small mb-1">{{ $item['title'] }}</h6>
                                    <h4 class="fw-bold mb-0">{{ $item['value'] }}</h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- GRAFIK --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center py-3">
                        <h5 class="fw-bold mb-0 text-white">Statistik Pengadaan Bulanan</h5>
                        <span class="badge bg-light-primary">Tahun {{ date('Y') }}</span>
                    </div>
                    <div class="card-body">
                        @if(!empty($chartData) && array_sum($chartData) > 0)
                            <div id="chart-pengadaan-bulanan" style="height: 320px;"></div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-bar-chart display-4 text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data pengadaan untuk tahun ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN --}}
            <div class="col-12 col-lg-3">
                {{-- Pengadaan Terbaru --}}
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-primary py-3">
                        <h5 class="fw-bold mb-0 text-white">Pengadaan Terbaru</h5>
                    </div>
                    <div class="card-body p-0">
                        @if ($recentPengadaan->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($recentPengadaan as $p)
                                    <div class="list-group-item border-0 px-3 py-3 pengadaan-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="flex-grow-1 me-2 text-truncate">
                                                <strong class="d-block text-dark text-truncate">{{ $p->kode_pengadaan }}</strong>
                                                <small class="text-muted d-block">{{ $p->created_at->format('d M Y') }}</small>
                                            </div>
                                            <span class="badge text-capitalize
                                                @if($p->status == 'diproses') bg-primary
                                                @elseif($p->status == 'disetujui') bg-success
                                                @elseif($p->status == 'ditolak') bg-danger
                                                @elseif($p->status == 'selesai') bg-info
                                                @else bg-secondary @endif">
                                                {{ ucfirst($p->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">Belum ada data pengadaan terbaru.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Tombol Logout --}}
                <div class="d-grid">
                    <a href="{{ route('logout') }}" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </div>
            </div>
        </section>
    </div>

    {{-- APEXCHART --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const data = @json($chartData ?? []);
            const bulan = @json($bulan ?? []);

            if (data.length > 0) {
                const chart = new ApexCharts(document.querySelector("#chart-pengadaan-bulanan"), {
                    chart: { type: 'line', height: 320, toolbar: { show: false } },
                    series: [{ name: "Jumlah Pengadaan", data }],
                    xaxis: { categories: bulan },
                    colors: ['#435ebe'],
                    stroke: { width: 3, curve: 'smooth' },
                    markers: { size: 5 },
                    dataLabels: { enabled: true },
                    grid: { borderColor: '#f1f1f1', strokeDashArray: 3 }
                });
                chart.render();
            }
        });
    </script>

    {{-- STYLE --}}
    <style>
        .stats-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
            transition: all 0.25s ease-in-out;
            background-color: #fff;
            text-align: center;
            min-height: 160px;
        }

        .stats-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .stats-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
        }

        .stats-icon.blue { background-color: #0d6efd; }
        .stats-icon.green { background-color: #198754; }
        .stats-icon.red { background-color: #dc3545; }
        .stats-icon.purple { background-color: #6f42c1; }

        .stats-icon i {
            font-size: 1.6rem;
            color: #fff;
            transform: translate(-5px, -3px); /* geser dikit kanan & naik */
        }

        .stats-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            display: flex; /* kunci utama */
            align-items: center; /* vertikal center */
            justify-content: center; /* horizontal center */
            line-height: 1;
            position: relative;
            margin: 0 auto 0.75rem auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }


        .stats-card h6 {
            color: #6c757d;
            font-weight: 500;
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }

        .stats-card h4 {
            font-weight: 700;
            color: #1b1b3a;
        }

        .list-group-item {
            transition: all 0.2s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</div>
