<?php

namespace App\Livewire\Categori;

use Livewire\Component;
use App\Models\Category;

class Categori extends Component
{
    public $category_id;
    public $categories = '';
    public $keterangan = '';
    public $isEdit = false;
    public $title = 'Add New Category';

    public function save()
    {
        $this->validate([
            'categories' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Category::updateOrCreate(['id' => $this->category_id], [
            'categories' => $this->categories,
            'keterangan' => $this->keterangan,
        ]);

        session()->flash('message', $this->category_id ? 'Category updated successfully.' : 'Category added successfully.');
        $this->resetFields();
        $this->dispatch('hide-modal');
        $this->dispatch('close');
        $this->dispatch('sweet', icon: 'success', title: $this->category_id ? 'Category is updated.' : 'Category is added.', text: $this->category_id ? 'Category is updated.' : 'Category is added.');
    }

    public function edit($id)
    {
        $this->title = 'Edit Category';
        $category = Category::findOrFail($id);

        $this->category_id = $id;
        $this->categories = $category->categories;
        $this->keterangan = $category->keterangan;
        $this->isEdit = true;

        $this->dispatch('editCategory');
        $this->dispatch('show-category-modal');
    }
}
