<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('batch_fish', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained()->onDelete('cascade');
            $table->foreignId('fish_id')->constrained('fishes')->onDelete('cascade');
            $table->decimal('quantity', 8, 2);
            $table->enum('unit', ['kg', 'pieces'])->default('kg');
            $table->decimal('available_quantity', 8, 2)->default(0);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_fish');
    }
};
