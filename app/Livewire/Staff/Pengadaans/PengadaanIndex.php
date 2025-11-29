<?php

namespace App\Livewire\Staff\Pengadaans;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Pengadaan;
use App\Models\PengadaanItem;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengadaanIndex extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $bukti = [];               // file upload per pengadaan
    public $showUploadModal = 0;      // ID pengadaan yang modalnya muncul

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // ====================================
    // Upload Bukti Pengadaan
    // ====================================
    public function uploadBukti($pengadaanId)
    {
        $this->validate([
            "bukti.$pengadaanId" => 'required|image|max:2048',
        ]);

        $pengadaan = Pengadaan::find($pengadaanId);

        if (!$pengadaan || $pengadaan->status !== 'disetujui') {
            session()->flash('error', 'Pengadaan tidak ditemukan atau belum disetujui.');
            return;
        }

        // Simpan file ke storage/public/bukti_pengadaan
        $path = $this->bukti[$pengadaanId]->store('bukti_pengadaan', 'public');

        $pengadaan->bukti_pembelian = $path;
        $pengadaan->status = 'selesai';
        $pengadaan->tanggal_selesai = now();
        $pengadaan->save();

        // Update stok barang otomatis
        $items = PengadaanItem::where('pengadaan_id', $pengadaan->id)->get();
        foreach ($items as $item) {
            $barang = Barang::find($item->barang_id);
            if ($barang) {
                $barang->stok += $item->jumlah;
                $barang->save();
            }
        }

        // Setelah berhasil upload bukti
        $this->dispatch('bukti-uploaded',
            message: 'Bukti pengadaan berhasil diupload!',
        );

        // Reset modal dan input file
        unset($this->bukti[$pengadaanId]);
        $this->showUploadModal = 0;
    }

    // ====================================
    // Hapus Pengadaan (Soft Delete dengan Logic)
    // ====================================
    public function deletePengadaan($pengadaanId)
    {
        $pengadaan = Pengadaan::find($pengadaanId);

        if (!$pengadaan) {
            session()->flash('error', 'Pengadaan tidak ditemukan.');
            return;
        }

        // Cek kepemilikan data
        if ($pengadaan->pengaju_id !== Auth::id()) {
            session()->flash('error', 'Anda tidak memiliki akses untuk menghapus pengadaan ini.');
            return;
        }

        try {
            // LOGIKA KHUSUS BERDASARKAN STATUS
            if ($pengadaan->status === 'diproses') {
                // Jika status "diproses" → ubah status menjadi "ditolak"
                $pengadaan->status = 'ditolak';
                $pengadaan->alasan_penolakan = 'Pengadaan dibatalkan oleh staff';
                $pengadaan->save();

                // Kemudian soft delete
                $pengadaan->delete();

                session()->flash('success', 'Pengadaan dibatalkan dan status diubah menjadi ditolak.');

            } elseif (in_array($pengadaan->status, ['disetujui', 'ditolak', 'selesai'])) {
                // Jika status "disetujui", "ditolak", atau "selesai"
                // → soft delete tanpa mengubah status

                $pengadaan->delete();

                session()->flash('success', 'Pengadaan berhasil dihapus. Status tetap dipertahankan untuk arsip admin.');

            } else {
                // Status lainnya, soft delete biasa
                $pengadaan->delete();
                session()->flash('success', 'Pengadaan berhasil dihapus.');
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus pengadaan: ' . $e->getMessage());
        }
    }

    // ====================================
    // Render Blade
    // ====================================
    public function render()
    {
        // HANYA tampilkan data yang BELUM di-soft delete
        // Staff tidak bisa lihat data yang sudah dihapus
        $pengadaans = Pengadaan::query() // Tanpa withTrashed()
            ->with('pengaju')
            ->where('pengaju_id', Auth::id())
            ->where(function ($query) {
                $query->where('kode_pengadaan', 'like', "%{$this->search}%")
                      ->orWhere('status', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.staff.pengadaans.pengadaan-index', [
            'pengadaans' => $pengadaans
        ]);
    }
}
