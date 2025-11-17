<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Models\Pengadaan;
use Illuminate\Support\Facades\Auth;

class DashboardStaff extends Component
{
    public $totalPengadaan = 0;
    public $totalDiproses = 0;
    public $totalDisetujui = 0;
    public $totalDitolak = 0;
    public $totalSelesai = 0;
    public $recentPengadaan;
    public $bulan = [];
    public $chartData = [];

    public function mount()
    {
        $userId = Auth::id();

        $this->totalPengadaan = Pengadaan::where('pengaju_id', $userId)->count();
        $this->totalDiproses  = Pengadaan::where('pengaju_id', $userId)->where('status', 'diproses')->count();
        $this->totalDisetujui = Pengadaan::where('pengaju_id', $userId)->where('status', 'disetujui')->count();
        $this->totalDitolak   = Pengadaan::where('pengaju_id', $userId)->where('status', 'ditolak')->count();
        $this->totalSelesai   = Pengadaan::where('pengaju_id', $userId)->where('status', 'selesai')->count();

        $this->recentPengadaan = Pengadaan::where('pengaju_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Data untuk grafik per bulan
        $pengadaanBulanan = Pengadaan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('pengaju_id', $userId)
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $namaBulan = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];

        $this->bulan = $pengadaanBulanan->pluck('bulan')->map(fn($b) => $namaBulan[$b])->toArray();
        $this->chartData = $pengadaanBulanan->pluck('total')->toArray();
    }

    public function render()
    {
        return view('livewire.staff.dashboard-staff');
    }
}
