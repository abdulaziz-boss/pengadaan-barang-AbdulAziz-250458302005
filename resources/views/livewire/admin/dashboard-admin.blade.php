    <div>
        <div class="page-content">
            <section class="row">
                <div class="col-12 col-lg-9">
                    <div class="row mb-4">
                        @php
                            $stats = [
                                ['title' => 'Total Barang', 'value' => $totalBarang, 'icon' => 'bi-box', 'color' => 'purple'],
                                ['title' => 'Total Pengadaan', 'value' => $totalPengadaan, 'icon' => 'bi-cart-check', 'color' => 'blue'],
                                ['title' => 'Total Kategori', 'value' => $totalKategori, 'icon' => 'bi-tags', 'color' => 'green'],
                                ['title' => 'Total Log Aktivitas', 'value' => $logs->count(), 'icon' => 'bi-activity', 'color' => 'red'],
                            ];
                        @endphp

                        @foreach ($stats as $item)
                            <div class="col-6 col-lg-3 col-md-6 mb-3">
                                <div class="card shadow-sm border-0 h-100 stats-card">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-3">
                                        <div class="stats-icon {{ $item['color'] }} mb-2">
                                            <i class="bi {{ $item['icon'] }}"></i>
                                        </div>
                                        <h6 class="text-muted font-semibold small mb-1">{{ $item['title'] }}</h6>
                                        <h4 class="fw-bold mb-0">{{ $item['value'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-primary d-flex justify-content-between align-items-center py-3">
                                    <h5 class="mb-0 fw-bold text-white">Statistik Pengadaan Bulanan</h5>
                                    <span class="badge bg-light-primary ">Tahun {{ date('Y') }}</span>
                                </div>
                                <div class="card-body">
                                    @if(!empty($chartData) && array_sum($chartData) > 0)
                                        <div id="chart-pengadaan-bulanan" style="height: 300px;"></div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-bar-chart display-4 text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada data pengadaan untuk tahun ini</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom kanan: Pengadaan terbaru dan tombol lofgout --}}
                <div class="col-12 col-lg-3">

                    {{-- Pengadaan Terbaru --}}
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-primary py-3">
                            <h5 class="mb-0 fw-bold text-white">Pengadaan Terbaru</h5>
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
                                                <span class="badge text-capitalize status-badge
                                                    @if($p->status == 'selesai') bg-success
                                                    @elseif($p->status == 'proses') bg-warning
                                                    @elseif($p->status == 'pending') bg-secondary
                                                    @else bg-info @endif">
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

        {{-- Grafik JS --}}
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                if (typeof @this.chartData !== 'undefined' && @this.chartData.length > 0) {
                    renderChart();
                }

                Livewire.on('chartUpdated', () => {
                    renderChart();
                });
            });

            function renderChart() {
                const chartElement = document.querySelector("#chart-pengadaan-bulanan");
                if (!chartElement) return;

                if (window.pengadaanChart) {
                    window.pengadaanChart.destroy();
                }

                var options = {
                    chart: {
                        type: 'line',
                        height: 320,
                        toolbar: { show: false },
                        zoom: { enabled: false },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    series: [{
                        name: 'Jumlah Pengadaan',
                        data: @json($chartData ?? [])
                    }],
                    xaxis: {
                        categories: @json($bulan ?? []),
                        labels: { style: { colors: '#6c757d', fontSize: '13px' } },
                        axisBorder: { color: '#e9ecef' },
                        axisTicks: { color: '#dee2e6' }
                    },
                    yaxis: {
                        labels: { style: { colors: '#6c757d', fontSize: '13px' } },
                        title: {
                            text: 'Jumlah Barang',
                            style: { color: '#6c757d' }
                        }
                    },
                    colors: ['#435ebe'],
                    stroke: { width: 3, curve: 'smooth' },
                    markers: {
                        size: 5,
                        colors: ['#fff'],
                        strokeColors: '#435ebe',
                        strokeWidth: 2,
                        hover: { size: 7 }
                    },
                    grid: { borderColor: '#f1f1f1', strokeDashArray: 3 },
                    dataLabels: {
                        enabled: true,
                        background: {
                            enabled: true,
                            foreColor: '#fff',
                            borderRadius: 4,
                            padding: 4,
                            opacity: 0.8,
                        }
                    },
                    tooltip: {
                        theme: 'light',
                        y: { formatter: (val) => val + " pengadaan" }
                    }
                };

                window.pengadaanChart = new ApexCharts(chartElement, options);
                window.pengadaanChart.render();
            }
        </script>

        <style>
            /* ==== CARD UTAMA ==== */
            .stats-card {
                border: none;
                border-radius: 16px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
                transition: all 0.25s ease-in-out;
                background-color: #fff;
                text-align: center;
                min-height: 160px;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            /* Efek hover lembut */
            .stats-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            }

            /* ==== IKON DALAM CARD ==== */
            .stats-icon {
                width: 55px;
                height: 55px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                line-height: 1;
                position: relative;
                margin: 0 auto 0.75rem auto;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            /* Warna dasar ikon */
            .stats-icon.purple { background-color: #6f42c1; }
            .stats-icon.blue { background-color: #0d6efd; }
            .stats-icon.green { background-color: #198754; }
            .stats-icon.red { background-color: #dc3545; }

            /* Ikon-nya */
            .stats-icon i {
            font-size: 1.6rem;
            color: #fff;
            transform: translate(-5px, -3px); /* geser dikit kanan & naik */
        }

            /* Hover effect pada ikon */
            .stats-card:hover .stats-icon {
                transform: scale(1.15) rotate(3deg);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }
            .stats-card:hover .stats-icon i {
                transform: translateY(2px) scale(1.1);
            }

            /* ==== TEKS ==== */
            .stats-card h6 {
                color: #6c757d;
                font-weight: 500;
                font-size: 0.85rem;
                margin-bottom: 0.25rem;
            }
            .stats-card h4 {
                font-weight: 700;
                color: #1b1b3a;
                margin: 0;
            }

            /* ==== RESPONSIVE ==== */
            @media (max-width: 768px) {
                .stats-card {
                    min-height: 130px;
                    padding: 0.75rem;
                }
                .stats-icon {
                    width: 48px;
                    height: 48px;
                }
                .stats-icon i {
                    font-size: 1.3rem;
                    transform: translateY(1px);
                }
            }x
        </style>
    </div>
