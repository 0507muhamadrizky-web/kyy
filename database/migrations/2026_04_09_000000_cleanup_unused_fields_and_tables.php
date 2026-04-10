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
        // 1. Remove telegram_chat_id from users
        if (Schema::hasColumn('users', 'telegram_chat_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['telegram_chat_id']);
                $table->dropColumn('telegram_chat_id');
            });
        }

        // 2. Remove kategori_barang_id from peminjamans
        if (Schema::hasColumn('peminjamans', 'kategori_barang_id')) {
            Schema::table('peminjamans', function (Blueprint $table) {
                $table->dropForeign(['kategori_barang_id']);
                $table->dropColumn('kategori_barang_id');
            });
        }

        // 3. Drop table kategori_barangs
        Schema::dropIfExists('kategori_barangs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('kategori_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::table('peminjamans', function (Blueprint $table) {
            $table->unsignedBigInteger('kategori_barang_id')->nullable()->after('user_id');
            $table->foreign('kategori_barang_id')->references('id')->on('kategori_barangs')->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('telegram_chat_id')->nullable()->unique()->after('email');
        });
    }
};
