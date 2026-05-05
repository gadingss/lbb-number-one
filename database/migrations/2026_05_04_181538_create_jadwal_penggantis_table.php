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
        Schema::create('jadwal_penggantis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_izin_id')->constrained('pengajuan_izins')->onDelete('cascade');
            $table->foreignId('jadwal_id')->constrained('jadwals')->onDelete('cascade');
            $table->date('tanggal_pengganti');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status', ['menunggu_dilaksanakan', 'selesai', 'dibatalkan'])->default('menunggu_dilaksanakan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_penggantis');
    }
};
