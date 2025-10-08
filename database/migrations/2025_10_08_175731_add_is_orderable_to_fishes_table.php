<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fishes', function (Blueprint $table) {
            $table->boolean('is_orderable')->default(false)->after('image');
        });
    }

    public function down()
    {
        Schema::table('fishes', function (Blueprint $table) {
            $table->dropColumn('is_orderable');
        });
    }
};