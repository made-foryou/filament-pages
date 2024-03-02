<?php

namespace MadeForYou\FilamentPages\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
class Page extends Model
{
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
}
