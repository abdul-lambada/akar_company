<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('category_id');
            $table->primary(['post_id', 'category_id']);

            $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_categories');
    }
};