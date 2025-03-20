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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id('no_urut');
        $table->string('nik', 50);
        $table->date('tanggal_booking');
        $table->date('tanggal_penanganan');
        $table->string('no_antrian_per_hari');
    
        // Detail kendaraan
        $table->string('nopol', 20);
        $table->string('merek', 100);
        $table->string('tipe', 100);
        $table->string('transmisi', 50);
        $table->integer('kapasitas');
        $table->year('tahun');
    
        $table->timestamps();
    
        // Foreign Key ke pelanggan
        $table->foreign('nik')->references('ktp')->on('pelanggan')->onDelete('cascade');
    });    
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};