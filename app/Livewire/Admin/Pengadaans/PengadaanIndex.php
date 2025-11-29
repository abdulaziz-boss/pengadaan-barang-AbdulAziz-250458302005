<?php

namespace App\Livewire\Admin\Pengadaans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengadaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PengadaanIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 8;

    // selected as associative array: [id => true]
    public $selected = [];

    public $selectPage = false;   // select all items on current page
    public $selectAll = false;    // select all across pages

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'deleteConfirmed' => 'deleteSelected',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
        $this->selectPage = false;

        foreach ($this->currentPageIds() as $id) {
            unset($this->selected[$id]);
        }
    }

    protected function baseQuery()
    {
        // PENTING: withTrashed() agar data yang di-soft delete staff tetap muncul
        return Pengadaan::withTrashed()
            ->with(['pengaju'])
            ->when($this->search, function ($q) {
                $s = "%{$this->search}%";
                $q->where('kode_pengadaan', 'like', $s)
                  ->orWhereHas('pengaju', fn($u) => $u->where('name', 'like', $s));
            })
            ->orderBy('created_at', 'desc');
    }

    protected function currentPageIds()
    {
        return $this->baseQuery()
            ->paginate($this->perPage)
            ->pluck('id')
            ->toArray();
    }

    public function updatedSelectPage($value)
    {
        $current = $this->currentPageIds();

        if ($value) {
            foreach ($current as $id) {
                $this->selected[$id] = true;
            }
        } else {
            foreach ($current as $id) {
                unset($this->selected[$id]);
            }
            $this->selectAll = false;
        }
    }

    public function selectAllAcrossPages()
    {
        $this->selectAll = true;
        $this->selectPage = true;

        // Include soft deleted records
        $ids = Pengadaan::withTrashed()->pluck('id')->toArray();

        $this->selected = [];
        foreach ($ids as $id) {
            $this->selected[$id] = true;
        }
    }

    public function unselectAll()
    {
        $this->selected = [];
        $this->selectPage = false;
        $this->selectAll = false;
    }

    public function deleteSelected()
    {
        $ids = array_keys(array_filter($this->selected));

        if (empty($ids)) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Tidak ada data yang dipilih.'
            ]);
            return;
        }

        try {
            // HARD DELETE untuk admin (bukan soft delete)
            // forceDelete() akan menghapus permanen bahkan yang sudah soft deleted
            $deleted = Pengadaan::withTrashed()
                ->whereIn('id', $ids)
                ->forceDelete();

            $this->selected = [];
            $this->selectPage = false;
            $this->selectAll = false;

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "$deleted data berhasil dihapus permanen."
            ]);

            $this->resetPage();

        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ]);
        }
    }

    // EXPORT EXCEL
    public function exportExcel()
    {
        $ids = array_keys(array_filter($this->selected));

        if (empty($ids)) {
            session()->flash('error', 'Pilih data terlebih dahulu.');
            return;
        }

        $pengadaans = Pengadaan::withTrashed()
            ->with(['pengaju'])
            ->whereIn('id', $ids)
            ->get();

        return Excel::download(new class($pengadaans) implements FromView, ShouldAutoSize {
            public $pengadaans;
            public function __construct($p) { $this->pengadaans = $p; }
            public function view(): View {
                return view('exports.pengadaan-excel', [
                    'data' => $this->pengadaans
                ]);
            }
        }, 'Laporan_Pengadaan.xlsx');
    }

    // EXPORT PDF
    public function exportPdf()
    {
        $ids = array_keys(array_filter($this->selected));

        if (empty($ids)) {
            session()->flash('error', 'Pilih data terlebih dahulu.');
            return;
        }

        $pengadaans = Pengadaan::withTrashed()
            ->with(['pengaju'])
            ->whereIn('id', $ids)
            ->get();

        $pdf = Pdf::loadView('exports.pengadaan-pdf', [
            'data' => $pengadaans
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'Laporan_Pengadaan.pdf'
        );
    }

    public function render()
    {
        return view('livewire.admin.pengadaans.index', [
            'pengadaans' => $this->baseQuery()->paginate($this->perPage),
        ]);
    }
}
