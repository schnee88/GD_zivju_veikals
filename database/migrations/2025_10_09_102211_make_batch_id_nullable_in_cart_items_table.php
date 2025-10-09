<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('cart_items_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
            $table->foreignId('fish_id')->constrained('fishes')->onDelete('cascade');
            $table->decimal('quantity', 8, 2);
            $table->timestamps();
            
            $table->unique(['user_id', 'fish_id']);
        });

        Schema::dropIfExists('cart_items');

        Schema::rename('cart_items_temp', 'cart_items');
    }

    public function down(): void
    {
        Schema::create('cart_items_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade');
            $table->foreignId('fish_id')->constrained('fishes')->onDelete('cascade');
            $table->decimal('quantity', 8, 2);
            $table->timestamps();
            
            $table->unique(['user_id', 'batch_id', 'fish_id']);
        });

        Schema::dropIfExists('cart_items');
        Schema::rename('cart_items_temp', 'cart_items');
    }
};