<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;

class CategoryEdit extends Component
{
    public $categoryId;
    public $nama;
    public $deskripsi;

    public function mount($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->nama = $category->nama;
        $this->deskripsi = $category->deskripsi;
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ]);

        $this->dispatch('swal', title: 'Good job!', text: 'Kategori berhasil diperbarui!', icon: 'success');

        
    }

    public function render()
    {
        return view('livewire.admin.category-edit');
    }
}
