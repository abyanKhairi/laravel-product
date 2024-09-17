<?php

namespace App\Livewire\Categori;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Categori extends Component
{
    use WithPagination;

    public $category_id;
    public $categories = '';
    public $keterangan = '';

    public $isEdit = false;
    public $title = 'Add New Category';
    public $search;
    public $pagi = 5;

    public function mount()
    {
        $this->resetFields();
    }


    public function resetFields()
    {
        $this->title = 'Add New Category';
        $this->reset('categories', 'keterangan', 'category_id');
        $this->categories = '';
        $this->keterangan = ''; 
        $this->category_id = '';
        $this->isEdit = false;
    }

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

    public function cancel()
    {
        $this->resetFields();
        $this->dispatch('hide-modal');
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function render()
    {
        $categoriesQuery = Category::query();

        if ($this->search) {
            $categoriesQuery->where('categories', 'like', '%' . $this->search . '%');
        }

        $kategori = $categoriesQuery->latest()->paginate($this->pagi);

        return view('livewire.categori.categori', [
            'kategori' => $kategori,
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}
