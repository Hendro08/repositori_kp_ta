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
        Schema::create('tugas_akhir', function (Blueprint $table) {
            $table->id('id_ta');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('judul', 255);
            $table->string('jenis_ta', 100);
            $table->string('abstrak_file', 2048);
            $table->string('kata_kunci', 255);
            $table->text('latar_belakang');
            $table->string('pembimbing');
            $table->string('file_ta', 10240);
            $table->enum('status', ['terkumpul', 'disetujui', 'revisi'])->default('terkumpul');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_akhir');
    }
};
