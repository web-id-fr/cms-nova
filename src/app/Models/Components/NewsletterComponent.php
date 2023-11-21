<?php

namespace Webid\CmsNova\App\Models\Components;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;
use Webid\CmsNova\App\Models\Traits\HasStatus;

/**
 * Class NewsletterComponent.
 *
 * @property int $status
 */
class NewsletterComponent extends Model
{
    use HasFactory;
    use HasStatus;
    use HasTranslations;

    public const _STATUS_PUBLISHED = 1;
    public const _STATUS_DRAFT = 2;

    public array $translatable = [
        'title',
        'cta_name',
        'placeholder',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'newsletters_component';

    protected $fillable = [
        'name',
        'status',
        'title',
        'cta_name',
        'placeholder',
    ];

    public function templates(): MorphToMany
    {
        return $this->morphToMany(Template::class, 'component')
            ->withPivot('order')
        ;
    }
}
