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
        Schema::create('pengajuan_izins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwals')->onDelete('cascade');
            $table->foreignId('pengaju_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipe_pengaju', ['siswa', 'tutor']);
            $table->date('tanggal_izin');
            $table->text('alasan');
            $table->enum('status', [
                'menunggu_lawan',
                'menunggu_konfirmasi_pengaju',
                'reschedule_berhasil',
                'ditolak'
            ])->default('menunggu_lawan');
            $table->string('usulan_hari')->nullable();
            $table->time('usulan_jam_mulai')->nullable();
            $table->time('usulan_jam_selesai')->nullable();
            $table->date('usulan_tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_izins');
    }
};
