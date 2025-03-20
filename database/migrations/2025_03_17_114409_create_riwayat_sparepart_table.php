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
            $table->unsignedBigInteger('riwayat_id');
            $table->string('kode_sparepart', 20);
            $table->integer('jumlah'); // Jumlah sparepart yang digunakan
            $table->timestamps();

            // Foreign Key
            $table->foreign('riwayat_id')->references('id')->on('riwayat')->onDelete('cascade');
            $table->foreign('kode_sparepart')->references('kode')->on('sparepart')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('riwayat_sparepart');
    }
};
