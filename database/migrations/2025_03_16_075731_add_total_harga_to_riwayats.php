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
    Schema::table('riwayat', function (Blueprint $table) {
        $table->decimal('total_harga', 10, 2)->after('status')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat', function (Blueprint $table) {
            //
        });
    }
};
