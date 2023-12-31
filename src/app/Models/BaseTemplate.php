<?php

namespace Webid\CmsNova\App\Models;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;
use Webid\CmsNova\App\Models\Contracts\Menuable;
use Webid\CmsNova\App\Models\Traits\HasFlexible;
use Webid\CmsNova\App\Models\Traits\HasMenus;
use Webid\CmsNova\App\Models\Traits\HasStatus;

/**
 * Class BaseTemplate.
 *
 * @property int          $id
 * @property array|string $title
 * @property array|string $slug
 * @property bool|int     $homepage
 * @property int          $status
 * @property bool|int     $contains_articles_list
 * @property \DateTime    $publish_at
 * @property int          $parent_page_id
 */
abstract class BaseTemplate extends Model implements Menuable
{
    use HasFactory;
    use HasFlexible;
    use HasMenus;
    use HasStatus;
    use HasTranslations;

    public const _STATUS_PUBLISHED = 0;
    public const _STATUS_DRAFT = 1;

    public array $translatable = [
        'title',
        'slug',
        'metatitle',
        'metadescription',
        'opengraph_title',
        'opengraph_description',
        'opengraph_picture_alt',
        'menu_description',
        'meta_keywords',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'templates';

    protected $fillable = [
        'title',
        'slug',
        'status',
        'indexation',
        'follow',
        'metatitle',
        'metadescription',
        'opengraph_title',
        'opengraph_description',
        'opengraph_picture',
        'opengraph_picture_alt',
        'meta_keywords',
        'publish_at',
        'homepage',
        'menu_description',
        'contains_articles_list',
        'parent_id',
        'reference_page_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'publish_at' => 'datetime',
    ];

    public function getParentKeyName(): string
    {
        return 'parent_page_id';
    }

    public function related(): HasMany
    {
        return $this->hasMany(Component::class)
            ->orderBy('order')
        ;
    }

    public function isHomepage(): bool
    {
        return boolval($this->homepage);
    }

    public function containsArticlesList(): bool
    {
        return boolval($this->contains_articles_list);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Template::class, $this->getParentKeyName());
    }

    public function ancestorsAndSelf(): Collection
    {
        if ($this->parent) {
            $ancestors = $this->collectAncestors($this->parent);
        } else {
            $ancestors = [];
        }

        $parent = collect($ancestors)->reverse();

        return $parent->push($this);
    }

    public function getTranslationsAttribute(): array
    {
        return collect($this->getTranslatableAttributes())
            ->mapWithKeys(function (string $key) {
                return [$key => $this->getTranslations($key)];
            })
            ->toArray()
        ;
    }

    public function getFullPath(string $language): string
    {
        $fullPath = $language;
        $ancestorsAndSelf = $this->ancestorsAndSelf();

        foreach ($ancestorsAndSelf as $template) {
            if (! $template->homepage) {
                $translatedAttributes = $template->getTranslationsAttribute();
                if (isset($translatedAttributes['slug'][$language])) {
                    $fullPath = "{$fullPath}/{$translatedAttributes['slug'][$language]}";
                }
            }
        }

        return $fullPath;
    }

    public function getBreadcrumb(string $language): array
    {
        $fullPath = $language;
        $breadcrumb = [];
        $ancestorsAndSelf = $this->ancestorsAndSelf();

        foreach ($ancestorsAndSelf as $key => $template) {
            $translatedAttributes = $template->getTranslationsAttribute();
            if (isset($translatedAttributes['slug'][$language])) {
                $breadcrumb[$key]['url'] = "/{$fullPath}/{$translatedAttributes['slug'][$language]}";
                $breadcrumb[$key]['title'] = $translatedAttributes['title'][$language] ?? '';
                if (! $template->homepage) {
                    $fullPath = "{$fullPath}/{$translatedAttributes['slug'][$language]}";
                }
            }
        }

        return $breadcrumb;
    }

    public function referencePage(): BelongsTo
    {
        return $this->belongsTo(Template::class)
            ->where('status', Template::_STATUS_PUBLISHED)
        ;
    }

    protected static function booted()
    {
        static::deleted(function ($template) {
            try {
                DB::table('menuables')
                    ->orWhere(function ($query) use ($template) {
                        $query
                            ->where('menuable_id', '=', $template->getKey())
                            ->where('menuable_type', '=', get_class($template))
                        ;
                    })
                    ->orWhere(function ($query) use ($template) {
                        $query
                            ->where('parent_id', '=', $template->getKey())
                            ->where('parent_type', '=', get_class($template))
                        ;
                    })
                    ->delete()
                ;
            } catch (\Throwable $exception) {
                report($exception);
            }
        });
    }

    private function collectAncestors(Template $parent, array $ancestors = []): array
    {
        $ancestors[] = $parent;

        if ($parent->parent) {
            return $this->collectAncestors($parent->parent, $ancestors);
        }

        return $ancestors;
    }
}
