<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menghapus menu tidak boleh ikut menghapus riwayat pesanan.
        // Nama dan harga sudah tersimpan di order_items sebagai snapshot.
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id')->nullable()->change();
            $table->foreign('menu_id')->references('id')->on('menus')->nullOnDelete();
        });

        // Kolom JSON `items` duplikat dengan tabel order_items.
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('items');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->json('items')->nullable();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id')->nullable(false)->change();
            $table->foreign('menu_id')->references('id')->on('menus')->cascadeOnDelete();
        });
    }
};