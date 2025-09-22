<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->increments('testimonial_id');
            $table->string('client_name');
            $table->text('testimonial_text');
            $table->unsignedInteger('project_id')->index();
            $table->foreign('project_id')->references('project_id')->on('portfolio')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};