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
        Schema::table('books', function (Blueprint $table) {
            // Mengubah tipe kolom menjadi string (VARCHAR) dengan panjang yang cukup
            // Gunakan `string(500)` atau `text` untuk memastikan path URL bisa muat.
            $table->string('file_path', 500)->change();
            $table->string('cover_path', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Ini untuk kasus rollback.
            // Anda bisa mengubah kembali ke tipe data asli jika diperlukan.
            // Contoh jika sebelumnya integer:
            // $table->integer('file_path')->change();
            // $table->integer('cover_path')->change();
            // Atau biarkan kosong jika Anda tidak berencana rollback tipe kolom ini.
        });
    }
};