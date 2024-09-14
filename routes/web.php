<?php

use App\Livewire\Categori\Categori;
use App\Livewire\Products\Products;
use App\Livewire\Transaksi\Transaksi;
use App\Livewire\Transaksi\TransaksiList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("product", Products::class)->name("product");
Route::get("categori", Categori::class)->name("categori");
Route::get("transaksi", Transaksi::class)->name("transaksi");
Route::get("transaksiList", TransaksiList::class)->name("transaksiList");