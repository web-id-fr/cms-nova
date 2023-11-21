<?php

namespace Webid\CmsNova\Modules\Articles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Spatie\Translatable\HasTranslations;

/**
 * @property string              $name
 * @property Collection<Article> $articles
 * @property \DateTime           $publish_at
 * @property \DateTime           $updated_at
 */
class ArticleCategory extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'name',
    ];

    /**
     * @var array
     */
    protected $translatable = [
        'name',
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    /**
     * @return Collection<Article>
     */
    public function publishedArticlesForLang(string $language)
    {
        return $this->articles()->publishedForLang($language)->get();
    }
}
