<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Profil publik tim
            $table->string('job_title', 120)->nullable()->after('avatar');
            $table->text('short_bio')->nullable()->after('job_title');
            $table->boolean('is_public')->default(true)->after('short_bio');
            $table->unsignedInteger('display_order')->default(0)->after('is_public');

            // Sosial & kontak publik
            $table->string('linkedin_url', 255)->nullable()->after('display_order');
            $table->string('github_url', 255)->nullable()->after('linkedin_url');
            $table->string('instagram_url', 255)->nullable()->after('github_url');
            $table->string('website', 255)->nullable()->after('instagram_url');
            $table->string('whatsapp_public', 32)->nullable()->after('website');

            // Tambahan opsional
            $table->unsignedTinyInteger('years_of_experience')->nullable()->after('whatsapp_public');
            $table->json('expertise')->nullable()->after('years_of_experience');
            $table->json('skills')->nullable()->after('expertise');
            $table->string('slug', 160)->nullable()->unique()->after('skills');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'job_title','short_bio','is_public','display_order',
                'linkedin_url','github_url','instagram_url','website','whatsapp_public',
                'years_of_experience','expertise','skills','slug'
            ]);
        });
    }
};
