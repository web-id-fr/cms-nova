<?php

namespace Webid\CmsNova\App\Models\Popin;

use App\Models\Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
use Webid\CmsNova\App\Models\Traits\HasStatus;

/**
 * Class Popin.
 *
 * @property int $status
 */
class Popin extends Model
{
    use HasStatus;
    use HasTranslations;

    /**
     * Valeurs des statuts possibles.
     */
    public const _STATUS_DRAFT = 1;
    public const _STATUS_PUBLISHED = 2;

    public array $translatable = [
        'title',
        'description',
        'button_1_title',
        'button_1_url',
        'button_2_title',
        'button_2_url',
        'image_alt',
    ];

    protected $table = 'popins';

    protected $fillable = [
        'title',
        'status',
        'image',
        'image_alt',
        'description',
        'button_1_title',
        'button_1_url',
        'display_second_button',
        'display_call_to_action',
        'button_2_title',
        'button_2_url',
        'type',
        'button_name',
        'delay',
        'mobile_display',
        'pages',
        'max_display',
    ];

    public function templates(): BelongsToMany
    {
        return $this->belongsToMany(Template::class, 'popin_template');
    }
}
