// database/migrations/2025_01_XX_cleanup_batch_system.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Izdzēšam batch_id no cart_items
        if (Schema::hasColumn('cart_items', 'batch_id')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->dropForeign(['batch_id']);
                $table->dropColumn('batch_id');
            });
        }

        // 2. Izdzēšam batch_id no order_items
        if (Schema::hasColumn('order_items', 'batch_id')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropForeign(['batch_id']);
                $table->dropColumn('batch_id');
            });
        }

        // 3. Vienkāršojam batch_fish tabulu
        Schema::table('batch_fish', function (Blueprint $table) {
            // Dzēšam available_quantity
            if (Schema::hasColumn('batch_fish', 'available_quantity')) {
                $table->dropColumn('available_quantity');
            }

            // Dzēšam status
            if (Schema::hasColumn('batch_fish', 'status')) {
                $table->dropColumn('status');
            }
        });
    }

    public function down(): void
    {
        // Reverse changes ja nepieciešams
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
        });

        Schema::table('batch_fish', function (Blueprint $table) {
            $table->decimal('available_quantity', 8, 2)->default(0);
            $table->enum('status', ['available', 'sold', 'reserved'])->default('available');
        });
    }
};