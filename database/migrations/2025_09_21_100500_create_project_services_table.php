<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_services', function (Blueprint $table) {
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('service_id');
            $table->primary(['project_id', 'service_id']);

            $table->foreign('project_id')->references('project_id')->on('portfolio')->onDelete('cascade');
            $table->foreign('service_id')->references('service_id')->on('services')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_services');
    }
};