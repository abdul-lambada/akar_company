<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('portfolio_images', function (Blueprint $table) {
            $table->id();
            // Ubah tipe agar sesuai dengan portfolio.project_id (unsignedInteger)
            $table->unsignedInteger('project_id');
            $table->string('image_path', 2048);
            $table->timestamps();

            $table->foreign('project_id')
                ->references('project_id')
                ->on('portfolio')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_images');
    }
};