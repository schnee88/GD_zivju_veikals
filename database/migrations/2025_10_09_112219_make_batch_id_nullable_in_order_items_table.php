<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
            $table->foreignId('fish_id')->constrained('fishes')->onDelete('cascade');
            $table->decimal('quantity', 8, 2);
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });

        Schema::dropIfExists('order_items');
        Schema::rename('order_items_temp', 'order_items');
    }

    public function down(): void
    {
        Schema::create('order_items_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade');
            $table->foreignId('fish_id')->constrained('fishes')->onDelete('cascade');
            $table->decimal('quantity', 8, 2);
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });

        Schema::dropIfExists('order_items');
        Schema::rename('order_items_temp', 'order_items');
    }
};