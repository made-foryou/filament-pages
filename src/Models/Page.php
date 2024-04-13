<?php

namespace MadeForYou\FilamentPages\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use MadeForYou\FilamentPages\Database\Factories\PageFactory;
use MadeForYou\Routes\Contracts\HasRoute;
use MadeForYou\Routes\Models\WithRoute;

/**
 * ## Page model
 * _________________________________
 *
 * @property-read int $id
 * @property string $name
 * @property ?string $summary
 * @property array $content
 * @property bool $in_menu
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read ?Carbon $deleted_at
 *
 * @method static PageFactory factory($count = null, $state = [])
 *
 * @author Menno Tempelaar <menno@made-foryou.nl>
 * @package made-foryou/filament-pages
 */
final class Page extends Model implements HasRoute
{
    use HasFactory;
    use SoftDeletes;
    use WithRoute;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'content' => 'array',
        'in_menu' => 'bool',
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
        'in_menu',
    ];

    /**
     * @return string
     */
    #[\Override] public function getUrl(): string
    {
        return Str::slug($this->name);
    }

    /**
     * @return string
     */
    #[\Override] public function getRouteName(): string
    {
        return 'page.'.$this->id;
    }

    /**
     * @return string
     */
    #[\Override] public function getTitle(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    #[\Override] public function getType(): string
    {
        return 'Pagina';
    }

    /**
     * @return string
     */
    #[\Override] public function getResourceLink(): string
    {
        return '';
    }

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
