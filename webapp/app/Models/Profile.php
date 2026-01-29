<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'subtitle',
        'greeting',
        'name',
        'bio',
        'image',
        'cv_file',
        'phone',
        'email',
        'address',
        'social_links',
        'animated_texts',
        'background_image',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'animated_texts' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
}
