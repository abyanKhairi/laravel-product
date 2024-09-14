<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string("customer")->nullable(); // Changed 'costumer' to 'customer'
            $table->string("invoice")->unique(); // Added unique constraint to 'invoice'
            $table->date("tanggal_transaction");
            $table->decimal("pembayaran", 10, 2);
            $table->decimal("kembalian", 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
