<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;

class Categories extends Component
{
    public $nama, $deskripsi, $categoryId;
    public $isEdit = false;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'deskripsi' => 'required|string',
    ];

    // Tambahkan listener untuk hapus
    protected $listeners = ['deleteConfirmed' => 'deleteConfirmed'];

    public function resetForm()
    {
        $this->nama = '';
        $this->deskripsi = '';
        $this->isEdit = false;
        $this->categoryId = null;
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->nama = $category->nama;
        $this->deskripsi = $category->deskripsi;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();

        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ]);
    }

    // ===== Tambahan: fitur Hapus =====
    public function confirmDelete($id)
    {
        // Kirim event ke JS untuk munculkan SweetAlert
        $this->dispatch('swal-delete', id: $id);
    }

    #[\Livewire\Attributes\On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();

            // Setelah berhasil hapus, kirim event sukses
            $this->dispatch('swal-success', [
                'title' => 'Deleted!',
                'text' => 'Data kategori berhasil dihapus.',
                'icon' => 'success'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.categories', [
            'categories' => Category::latest()->get(),
        ]);
    }


}
