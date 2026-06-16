<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('meta_title', 70)->nullable()->after('slug');
            // meta_description already exists in create_pages_table migration
            $table->string('meta_keywords', 255)->nullable()->after('meta_description');
            $table->string('og_image', 500)->nullable()->after('meta_keywords');
            $table->boolean('no_index')->default(false)->after('og_image');
            $table->string('canonical_url', 500)->nullable()->after('no_index');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_keywords',
                'og_image',
                'no_index',
                'canonical_url'
            ]);
            // meta_description is not dropped (exists in original migration)
        });
    }
};
