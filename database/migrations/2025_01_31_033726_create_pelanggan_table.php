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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->string('ktp', 50)->primary();
            $table->string('nama', 100);
            $table->string('alamat', 255);
            $table->string('hp', 15);
            $table->timestamps();
        
            // Foreign Key ke users
            $table->foreign('ktp')->references('nik_ktp')->on('users')->onDelete('cascade');
        });        
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
