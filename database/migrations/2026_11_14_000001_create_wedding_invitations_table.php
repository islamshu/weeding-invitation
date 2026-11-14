<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('slug', 120)->unique();
            $table->boolean('enable_english')->default(false);

            $table->string('groom_name_ar', 120);
            $table->string('groom_name_en', 120)->nullable();
            $table->string('bride_name_ar', 120);
            $table->string('bride_name_en', 120)->nullable();
            $table->string('couple_note_ar', 255)->nullable();
            $table->string('couple_note_en', 255)->nullable();

            $table->json('groom_wakil')->nullable();
            $table->json('bride_wakil')->nullable();
            $table->json('invitation_content')->nullable();
            $table->json('event_details')->nullable();
            $table->json('design_settings')->nullable();

            $table->string('template_key', 60)->default('classic_royal');
            $table->string('status', 20)->default('draft');
            $table->timestamp('published_at')->nullable();

            $table->string('cover_image_path')->nullable();
            $table->string('background_image_path')->nullable();
            $table->string('decorative_image_path')->nullable();

            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();

            $table->index(['status', 'published_at']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_invitations');
    }
};
