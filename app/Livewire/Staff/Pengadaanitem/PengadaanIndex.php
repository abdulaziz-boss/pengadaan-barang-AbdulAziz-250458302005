<?php

namespace App\Livewire\Staff\Pengadaanitem;

use App\Models\Barang;
use App\Models\Category;
use App\Models\Pengadaan;
use App\Models\PengadaanItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PengadaanIndex extends Component
{
    public $barangList = [];
    public $categoryList = [];
    public $items = [];
    public $totalHarga = 0;

    public $modeBarang = 'pilih'; // pilih | baru
    public $modeKategori = 'pilih'; // pilih | baru

    public $newBarang = [
        'nama' => '',
        'category_id' => '',
        'harga_satuan' => '',
        'deskripsi' => '',
        'stok_minimal' => '',
        'satuan' => 'pcs',
    ];

    public $newCategory = [
        'nama' => '',
        'deskripsi' => '',
    ];

    public function mount()
    {
        $this->loadData();
        $this->addItem();
    }

    public function updatedModeBarang($value)
    {
        if ($value === 'baru') {
            $this->modeKategori = 'pilih';
        }
    }

    public function loadData()
    {
        $this->barangList = Barang::with('category')->get();
        $this->categoryList = Category::all();
    }

    public function addItem()
    {
        $this->items[] = [
            'barang_id' => '',
            'jumlah' => 1,
            'harga' => 0,
            'total' => 0,
        ];
        $this->calculateTotal();
    }

    public function removeItem($index)
    {
        if(count($this->items) > 1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
            $this->calculateTotal();
        }
    }

    public function updateItem($index)
    {
        if (!isset($this->items[$index])) return;

        $item = $this->items[$index];

        if (!empty($item['barang_id'])) {
            $barang = Barang::find($item['barang_id']);
            $harga = $barang->harga_satuan ?? 0;
            $jumlah = intval($item['jumlah'] ?? 1);

            $this->items[$index]['harga'] = $harga;
            $this->items[$index]['total'] = $harga * $jumlah;
        } else {
            $this->items[$index]['harga'] = 0;
            $this->items[$index]['total'] = 0;
        }

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalHarga = collect($this->items)->sum('total');
    }

    public function tambahBarang()
    {
        if ($this->modeKategori === 'baru') {
            $this->validate([
                'newCategory.nama' => 'required|string|max:255|unique:categories,nama',
            ]);

            $category = Category::create([
                'nama' => $this->newCategory['nama'],
                'deskripsi' => $this->newCategory['deskripsi'],
            ]);

            $this->newBarang['category_id'] = $category->id;
        }

        $this->validate([
            'newBarang.nama' => 'required|string|max:255|unique:barangs,nama',
            'newBarang.category_id' => 'required|exists:categories,id',
            'newBarang.harga_satuan' => 'required|numeric|min:0',
            'newBarang.stok_minimal' => 'required|integer|min:0',
            'newBarang.satuan' => 'required|string|max:20',
        ]);

        $barang = Barang::create([
            'nama' => $this->newBarang['nama'],
            'category_id' => $this->newBarang['category_id'],
            'harga_satuan' => $this->newBarang['harga_satuan'],
            'stok_minimal' => $this->newBarang['stok_minimal'],
            'satuan' => $this->newBarang['satuan'],
            'deskripsi' => $this->newBarang['deskripsi'],
            'stok' => 0,
        ]);

        $this->reset(['newBarang', 'newCategory', 'modeKategori']);
        $this->loadData();

        // Session flash dengan event untuk refresh
        session()->flash('success', 'Barang baru berhasil ditambahkan!');
        $this->dispatch('trigger-refresh');
    }

    public function save()
    {
        $this->resetValidation();

        $this->validate([
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        $validItems = array_filter($this->items, fn($item) =>
            !empty($item['barang_id']) && $item['jumlah'] > 0
        );

        if (empty($validItems)) {
            session()->flash('error', 'Minimal satu barang valid harus ditambahkan.');
            return;
        }

        DB::beginTransaction();
        try {
            $kode = 'PGD-' . now()->format('YmdHis');

            $pengadaan = Pengadaan::create([
                'kode_pengadaan' => $kode,
                'pengaju_id' => Auth::id(),
                'total_harga' => $this->totalHarga,
                'status' => 'diproses',
                'tanggal_pengajuan' => now(),
            ]);

            foreach ($validItems as $item) {
                $barang = Barang::find($item['barang_id']);
                PengadaanItem::create([
                    'pengadaan_id' => $pengadaan->id,
                    'barang_id' => $barang->id,
                    'jumlah' => $item['jumlah'],
                    'harga_saat_pengajuan' => $barang->harga_satuan,
                    'total_harga_item' => $item['jumlah'] * $barang->harga_satuan,
                ]);
            }

            DB::commit();

            // Session flash dengan event untuk refresh
            session()->flash('success', 'Pengajuan pengadaan berhasil! Kode: ' . $kode);
            $this->dispatch('trigger-refresh');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.staff.pengadaanitem.index');
    }
}
