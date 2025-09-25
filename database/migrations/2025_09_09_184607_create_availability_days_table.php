<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('availability_days', function (Blueprint $table) {
        $table->id();
        $table->foreignId('fish_id')->constrained('fishes')->onDelete('cascade');
        $table->date('date');
        $table->integer('quantity_available')->default(0);
        $table->timestamps();
        
        $table->unique(['fish_id', 'date']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availability_days');
    }
};
