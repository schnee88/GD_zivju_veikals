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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "Žāvējums: 14.00 2025.23.09."
            $table->dateTime('batch_date');
            $table->enum('status', ['available', 'sold_out', 'preparing'])->default('preparing');
            $table->text('description')->nullable(); // Papildus informācija
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
