<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('name');
            $table->tinyInteger('status_upload')->default(0)->after('disk');
            $table->tinyInteger('status_moderation')->default(0)->after('status_upload');
        });

        // Convert existing string data to tinyint
        DB::table('files')->where('status', 'uploading')->update(['status_upload' => 0]);
        DB::table('files')->where('status', 'processing')->update(['status_upload' => 1]);
        DB::table('files')->where('status', 'ready')->update(['status_upload' => 2]);

        DB::table('files')->where('moderation_status', 'pending')->update(['status_moderation' => 0]);
        DB::table('files')->where('moderation_status', 'approved')->update(['status_moderation' => 1]);
        DB::table('files')->where('moderation_status', 'rejected')->update(['status_moderation' => 2]);

        // Generate slugs for existing files
        DB::table('files')->get()->each(function ($file) {
            $slug = Str::slug($file->name).'-'.Str::random(5);
            DB::table('files')->where('id', $file->id)->update(['slug' => $slug]);
        });

        Schema::table('files', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
            $table->dropColumn(['status', 'moderation_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->string('status')->default('ready');
            $table->string('moderation_status')->default('pending');
        });

        // Convert back
        DB::table('files')->where('status_upload', 0)->update(['status' => 'uploading']);
        DB::table('files')->where('status_upload', 1)->update(['status' => 'processing']);
        DB::table('files')->where('status_upload', 2)->update(['status' => 'ready']);

        DB::table('files')->where('status_moderation', 0)->update(['moderation_status' => 'pending']);
        DB::table('files')->where('status_moderation', 1)->update(['moderation_status' => 'approved']);
        DB::table('files')->where('status_moderation', 2)->update(['moderation_status' => 'rejected']);

        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn(['slug', 'status_upload', 'status_moderation']);
        });
    }
};
