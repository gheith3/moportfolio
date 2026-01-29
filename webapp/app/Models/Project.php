<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'gallery_images',
        'project_url',
        'github_url',
        'client',
        'technologies',
        'completion_date',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
            'technologies' => 'array',
            'completion_date' => 'date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
