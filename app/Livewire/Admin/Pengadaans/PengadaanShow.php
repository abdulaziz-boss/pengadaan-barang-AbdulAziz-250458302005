<?php

namespace App\Livewire\Admin\Pengadaans;

use Livewire\Component;
use App\Models\Pengadaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PengadaanShow extends Component
{
    public $pengadaan;

    public function mount($id)
    {
        $this->pengadaan = Pengadaan::with(['pengaju', 'items.barang.category'])
            ->findOrFail($id);
    }

    public function exportDetailPdf()
    {
        if (!$this->pengadaan) {
            session()->flash('error', 'Data pengadaan tidak ditemukan!');
            return;
        }

        $pdf = Pdf::loadView('exports.pengadaan-detail-pdf', [
            'pengadaan' => $this->pengadaan
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'detail_pengadaan_' . $this->pengadaan->kode_pengadaan . '.pdf');
    }


    public function exportDetailExcel()
    {
        $pengadaan = $this->pengadaan;

        if (!$pengadaan) {
            session()->flash('error', 'Data pengadaan tidak ditemukan!');
            return;
        }

        return Excel::download(new class($pengadaan) implements FromView, ShouldAutoSize {
            protected $pengadaan;

            public function __construct($pengadaan)
            {
                $this->pengadaan = $pengadaan;
            }

            public function view(): View
            {
                return view('exports.pengadaan-detail-excel', [
                    'pengadaan' => $this->pengadaan
                ]);
            }
        }, 'detail_pengadaan_' . $pengadaan->kode_pengadaan . '.xlsx');
    }

    public function render()
    {
        return view('livewire.admin.pengadaans.show');
    }
}
