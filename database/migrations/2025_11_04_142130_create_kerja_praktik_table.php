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
        Schema::create('kerja_praktik', function (Blueprint $table) {
            $table->id('id_kp');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('judul', 255);
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->date('tgl_kumpul');
            $table->string('abstrak_file', 255);
            $table->string('kata_kunci', 255);
            $table->text('latar_belakang');
            $table->string('pembimbing');
            $table->string('file_kp', 255);
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
        Schema::dropIfExists('kerja_praktik');
    }
};
