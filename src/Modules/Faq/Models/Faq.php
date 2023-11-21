<?php

namespace Webid\CmsNova\Modules\Faq\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;
use Webid\CmsNova\App\Models\Traits\HasStatus;

/**
 * Class Faq.
 *
 * @property int $status
 */
class Faq extends Model
{
    use HasFactory;
    use HasStatus;
    use HasTranslations;

    public const _STATUS_PUBLISHED = 1;
    public const _STATUS_DRAFT = 2;

    public array $translatable = [
        'question',
        'answer',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faqs';

    protected $fillable = [
        'name',
        'question',
        'answer',
        'order',
        'status',
        'faq_theme_id',
    ];

    public function faqTheme(): BelongsTo
    {
        return $this->belongsTo(FaqTheme::class);
    }
}
