<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\SettingFactory> */
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => match ($this->type) {
                'boolean' => (bool) $value,
                'integer' => (int) $value,
                'array', 'object' => json_decode($value, true),
                default => $value,
            },
        );
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting?->value ?? $default;
    }

    public static function set(string $key, mixed $value, string $type = 'string'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) || is_object($value) ? json_encode($value) : $value,
                'type' => $type,
            ]
        );
    }
}
