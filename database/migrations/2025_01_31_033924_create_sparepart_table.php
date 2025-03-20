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
        Schema::create('riwayat_sparepart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_riwayat');
            $table->string('kode_sparepart', 20);
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('id_riwayat')->references('id')->on('riwayat')->onDelete('cascade');
            $table->foreign('kode_sparepart')->references('kode')->on('sparepart')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_sparepart');
    }
};
