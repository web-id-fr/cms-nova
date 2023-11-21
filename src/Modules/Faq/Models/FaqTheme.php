<?php

namespace Webid\CmsNova\Modules\Faq\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
use Webid\CmsNova\App\Models\Traits\HasStatus;

/**
 * Class FaqTheme.
 *
 * @property int $status
 */
class FaqTheme extends Model
{
    use HasFactory;
    use HasStatus;
    use HasTranslations;

    public const _STATUS_PUBLISHED = 1;
    public const _STATUS_DRAFT = 2;

    public array $translatable = [
        'title',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faq_themes';

    protected $fillable = [
        'title',
        'status',
    ];

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class)
            ->orderBy('order')
        ;
    }
}
