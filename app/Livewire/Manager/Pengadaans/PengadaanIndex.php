<?php

namespace App\Livewire\Manager\Pengadaans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengadaan;

class PengadaanIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshData' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setujui($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        $pengadaan->status = 'disetujui';
        $pengadaan->tanggal_disetujui = now();
        $pengadaan->save();

        session()->flash('success', 'Pengadaan berhasil disetujui!');
        $this->emit('refreshData');
    }

    public function tolak($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        $pengadaan->status = 'ditolak';
        $pengadaan->alasan_penolakan = 'Ditolak oleh manajer'; // opsional
        $pengadaan->save();

        session()->flash('danger', 'Pengadaan ditolak!');
        $this->emit('refreshData');
    }

    public function render()
    {
        $pengadaans = Pengadaan::with(['pengaju', 'items.barang'])
            ->when($this->search, function ($query) {
                $query->whereHas('items.barang', function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%');
                })->orWhereHas('pengaju', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.manager.pengadaans.pengadaan-index', [
            'pengadaans' => $pengadaans,
        ]);
    }
}
