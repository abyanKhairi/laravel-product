<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


class Products extends Component
{
    use WithPagination, WithFileUploads;

    public $product_id;
    public $name = '';
    public $jumlah;
    public $harga;
    public $category_id;
    public $description = '';
    public $image;

    public $isEdit = false;
    public $title = 'Add New Product';
    public $search;
    public $pagi = 5;

    public function mount()
    {
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->title = 'Add New Product';
        $this->reset('name', 'jumlah', 'harga', 'category_id', 'description', 'image', 'product_id');
        $this->name = '';
        $this->jumlah = '';
        $this->harga = '';
        $this->category_id = '';
        $this->description = '';
        $this->image = null;
        $this->product_id = '';
        $this->isEdit = false;
    }

    public function save()
    {
        $this->validate([
            'image' => 'nullable|image|max:1024|required_without:product_id', // Validate image
            'name' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'description' => 'nullable|string',
            'harga' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $productData = [
            'name' => $this->name,
            'jumlah' => $this->jumlah,
            'harga' => $this->harga,
            'category_id' => $this->category_id,
            'description' => $this->description,
        ];

        if ($this->image) {
            $imagePath = $this->image->store('images', 'public');
            $productData['image'] = $imagePath;
        }

        if ($this->product_id) {
            // Update product
            $product = Product::findOrFail($this->product_id);
            $product->update($productData);
        } else {
            // Create new product
            Product::create($productData);
        }

        session()->flash('message', $this->product_id ? 'Product updated successfully.' : 'Product added successfully.');
        $this->dispatch('hide-modal');
        $this->dispatch('close');
        $this->dispatch('sweet', icon: 'success', title: $this->product_id ? 'Product is updated.' : 'Product is added.', text: $this->product_id ? 'Product is updated.' : 'Product is added.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $this->title = 'Edit Product';
        $product = Product::findOrFail($id);

        $this->product_id = $id;
        $this->name = $product->name;
        $this->jumlah = $product->jumlah;
        $this->harga = $product->harga;
        $this->category_id = $product->category_id;
        $this->description = $product->description;
        $this->image = $product->image;
        $this->isEdit = true;

        $this->dispatch('editProduct');
        $this->dispatch('show-product-modal');
    }

    public function cancel()
    {
        $this->resetFields();
        $this->dispatch('hide-modal');
    }

    // public function delete($id)
    // {
    //     Product::find($id)->delete();
    //     session()->flash('message', 'Product deleted successfully.');
    // }


    public function delete($get_id)
    {
        try {
            $product = Product::findOrFail($get_id);
            
            Storage::delete('public/'. $product->image);

            $product->delete();

        } catch (\Exception $e) {
            $this->dispatch('sweet-alert', title:'Data Gagal Diubah', icon:'error');
        }
    }

    public function render()
    {
        $categories = Category::all();

        $productsQuery = Product::query();

        if ($this->search) {
            $productsQuery->where('name', 'like', '%' . $this->search . '%');
        }

        $products = $productsQuery->latest()->paginate($this->pagi);

        return view('livewire.products.products', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}