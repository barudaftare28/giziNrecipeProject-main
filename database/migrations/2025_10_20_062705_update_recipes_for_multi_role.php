<!-- user_id mencatat siapa posting resep -->
<!-- is_official: Sebagai penanda (flag) apakah resep ini "Official" 
(dibuat Admin/Pakar Gizi) atau resep komunitas (dibuat User biasa). -->

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('recipes', function (Blueprint $table) {
            
            // 1. TAMBAH: Foreign Key ke tabel users (Siapa yang memposting: User atau Admin)
            // Kolom ini dibuat nullable agar tidak error jika ada data lama yang belum memiliki user_id
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
            
            // 2. TAMBAH: Flag untuk Resep Official (TRUE = Admin/Pakar, FALSE = User Biasa)
            $table->boolean('is_official')->default(false)->after('nutritionist');
            
            // 3. MODIFIKASI: Kolom 'nutritionist' harus bisa NULL
            // Resep dari User tidak akan mengisi kolom ini. (Requires 'doctrine/dbal' for change() method if using MySQL)
            $table->string('nutritionist')->nullable()->change(); 
        });
    }

    public function down(): void {
        Schema::table('recipes', function (Blueprint $table) {
            // Urutan drop harus terbalik dari up()
            // Hapus foreign key dan kolom
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('is_official');
            
            // Revert 'nutritionist' kembali ke not nullable (jika diperlukan)
            // $table->string('nutritionist')->change(); 
        });
    }
};