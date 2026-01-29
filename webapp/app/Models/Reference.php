<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Reference extends Model
{
    /** @use HasFactory<\Database\Factories\ReferenceFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'slogan',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
