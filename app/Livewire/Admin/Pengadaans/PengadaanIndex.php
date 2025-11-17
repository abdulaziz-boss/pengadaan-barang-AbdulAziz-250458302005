<?php

namespace App\Livewire\Admin\Pengadaans;

use Livewire\Component;
use App\Models\Pengadaan;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class PengadaanIndex extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    // Reset halaman saat pencarian berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Trigger konfirmasi hapus (dikirim ke JS)
    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    // Listener untuk hapus setelah konfirmasi dari JS
    #[On('deleteConfirmed')]
    public function deletePengadaan($id)
    {
        try {
            $pengadaan = Pengadaan::findOrFail($id);
            $pengadaan->delete();

            // Kirim notifikasi sukses ke JS
            $this->dispatch('swal:success', [
                'title' => 'Berhasil!',
                'text' => 'Data pengadaan berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            // Kirim notifikasi error ke JS
            $this->dispatch('swal:error', [
                'title' => 'Gagal!',
                'text' => 'Terjadi kesalahan saat menghapus data.',
            ]);
        }
    }

    public function render()
    {
        $pengadaans = Pengadaan::with('pengaju')
            ->when($this->search, function($query) {
                $query->where('kode_pengadaan', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(8); // ✅ hanya pakai paginate, tanpa get()

        return view('livewire.admin.pengadaans.index', [
            'pengadaans' => $pengadaans,
        ]);
    }
}
