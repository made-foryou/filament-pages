<?php

namespace MadeForYou\FilamentPages\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MadeForYou\FilamentPages\Database\Factories\PageFactory;
use MadeForYou\Helpers\Models\ModelWithContentBlocks;
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
 * @property null|string $meta_title
 * @property null|string $meta_description
 * @property null|string $meta_image
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read ?Carbon $deleted_at
 *
 * @method static PageFactory factory($count = null, $state = [])
 *
 * @author Menno Tempelaar <menno@made-foryou.nl>
 */
final class Page extends Model implements HasRoute, ModelWithContentBlocks
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
        'meta_title',
        'meta_description',
        'meta_image',
    ];

    #[\Override]
    public function getUrl(): string
    {
        return Str::slug($this->name);
    }

    #[\Override]
    public function getRouteName(): string
    {
        return 'page.' . $this->id;
    }

    #[\Override]
    public function getTitle(): string
    {
        return $this->name;
    }

    #[\Override]
    public function getType(): string
    {
        return 'Pagina';
    }

    #[\Override]
    public function getResourceLink(): string
    {
        return '';
    }

    #[\Override]
    public function getContents(?string $key = null): Collection
    {
        $registered = collect(config('made-filament-pages.content_blocks'));
        $key = $key ?? 'content';

        return collect($this->getAttribute($key))
            ->map(function (array $part) use ($registered) {
                $found = $registered->first(
                    fn (string $block) => $block::id() === $part['type']
                );

                if (! $found) {
                    return null;
                }

                return new $found($part['data']);
            });
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): PageFactory
    {
        return PageFactory::new();
    }
}
