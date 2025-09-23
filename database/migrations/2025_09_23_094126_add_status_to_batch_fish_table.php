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
        Schema::table('batch_fish', function (Blueprint $table) {
            $table->enum('status', ['available', 'sold', 'reserved'])->default('available')->after('available_quantity');
        });
    }

    public function down(): void
    {
        Schema::table('batch_fish', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
