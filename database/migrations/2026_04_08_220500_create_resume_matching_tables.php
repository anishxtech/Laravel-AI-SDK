<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resume_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('source_label')->nullable();
            $table->longText('raw_text');
            $table->json('parsed_json')->nullable();
            $table->json('embedding')->nullable();
            $table->timestamps();
        });

        Schema::create('job_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title')->nullable();
            $table->longText('raw_text');
            $table->json('parsed_json')->nullable();
            $table->json('embedding')->nullable();
            $table->timestamps();
        });

        Schema::create('resume_job_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_profile_id')->constrained()->cascadeOnDelete();
            $table->decimal('cosine_similarity', 10, 6)->default(0);
            $table->decimal('rerank_score', 10, 6)->nullable();
            $table->decimal('match_score', 10, 6)->default(0);
            $table->text('gap_summary')->nullable();
            $table->json('strengths')->nullable();
            $table->json('missing_skills')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resume_job_matches');
        Schema::dropIfExists('job_profiles');
        Schema::dropIfExists('resume_profiles');
    }
};
