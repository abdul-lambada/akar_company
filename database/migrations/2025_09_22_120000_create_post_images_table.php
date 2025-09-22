<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Pastikan tabel lama yang mungkin tercipta saat migrasi gagal dihapus lebih dulu
        Schema::dropIfExists('post_images');

        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            // Ubah tipe agar sesuai dengan posts.post_id (unsignedInteger)
            $table->unsignedInteger('post_id');
            $table->string('image_path', 2048);
            $table->timestamps();

            $table->foreign('post_id')
                ->references('post_id')
                ->on('posts')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_images');
    }
};