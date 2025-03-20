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
        Schema::create('riwayat', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('keluhan', 255);
            $table->string('penanganan', 255);
            $table->string('catatan', 255);
    
            // Pastikan kolom ini menggunakan unsignedBigInteger jika id_karyawan adalah unsignedBigInteger
            $table->unsignedBigInteger('id_karyawan');
            $table->foreign('id_karyawan')->references('id')->on('karyawan')->onDelete('cascade');
    
            $table->string('nopol', 20);
            $table->foreign('nopol')->references('nopol')->on('kendaraan')->onDelete('cascade');
    
            $table->unsignedBigInteger('id_jasa');
            $table->foreign('id_jasa')->references('id')->on('jasa_servis')->onDelete('cascade');
    
            $table->string('kode_sparepart', 20);
            $table->foreign('kode_sparepart')->references('kode')->on('sparepart')->onDelete('cascade');
    
            $table->string('ktp_pelanggan', 50);
            $table->foreign('ktp_pelanggan')->references('ktp')->on('pelanggan')->onDelete('cascade');
    
            $table->string('status', 50);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};
