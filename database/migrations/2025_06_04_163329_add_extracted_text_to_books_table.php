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
            // Tambahkan kolom extracted_text
            // longText cocok untuk teks panjang, bisa menyimpan hingga 4GB di MySQL
            $table->longText('extracted_text')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Hapus kolom extracted_text saat rollback
            $table->dropColumn('extracted_text');
        });
    }
};