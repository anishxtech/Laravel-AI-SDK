<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResumeProfile extends Model
{
    protected $fillable = [
        'user_id',
        'source_label',
        'raw_text',
        'parsed_json',
        'embedding',
    ];

    protected function casts(): array
    {
        return [
            'parsed_json' => 'array',
            'embedding' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(ResumeJobMatch::class);
    }
}
