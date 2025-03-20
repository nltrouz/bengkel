<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->timestamp('waktu_datang')->nullable()->after('tanggal_penanganan');
            $table->enum('status', ['Tunggu', 'Disetujui', 'Dibatalkan'])->default('Tunggu')->after('waktu_datang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['waktu_datang', 'status']);
        });
    }
};
