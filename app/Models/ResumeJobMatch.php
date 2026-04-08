<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeJobMatch extends Model
{
    protected $fillable = [
        'resume_profile_id',
        'job_profile_id',
        'cosine_similarity',
        'rerank_score',
        'match_score',
        'gap_summary',
        'strengths',
        'missing_skills',
    ];

    protected function casts(): array
    {
        return [
            'strengths' => 'array',
            'missing_skills' => 'array',
        ];
    }

    public function resumeProfile(): BelongsTo
    {
        return $this->belongsTo(ResumeProfile::class);
    }

    public function jobProfile(): BelongsTo
    {
        return $this->belongsTo(JobProfile::class);
    }
}
