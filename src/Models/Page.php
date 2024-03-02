<?php

namespace MadeForYou\FilamentPages\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MadeForYou\FilamentPages\Database\Factories\PageFactory;

/**
 * ## Page model
 * ___
 *
 * @property-read int $id
 * @property string $name
 * @property ?string $summary
 * @property array $content
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read ?Carbon $deleted_at
 */
final class Page extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'content' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'summary',
        'content',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return PageFactory
     */
    protected static function newFactory(): PageFactory
    {
        return PageFactory::new();
    }
}
