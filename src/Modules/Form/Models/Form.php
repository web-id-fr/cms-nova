<?php

namespace Webid\CmsNova\Modules\Form\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\Translatable\HasTranslations;
use Webid\CmsNova\App\Models\Traits\HasStatus;

/**
 * Class Form.
 *
 * @property Collection $fields
 * @property Collection $titleFields
 * @property int        $status
 */
class Form extends Model
{
    use HasFactory;
    use HasStatus;
    use HasTranslations;

    public const _STATUS_PUBLISHED = 0;
    public const _STATUS_DRAFT = 1;

    public const _RECIPIENTS = 1;
    public const _SERVICES = 2;

    public const TYPE_TO_SERVICE = [
        self::_RECIPIENTS => 'Recipients',
        self::_SERVICES => 'Services',
    ];

    /** @var Collection */
    public $field_items;

    public array $translatable = [
        'title',
        'description',
        'title_service',
        'cta_name',
        'rgpd_mention',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forms';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'related.formables',
        'services',
        'services.recipients',
        'recipients',
    ];

    protected $fillable = [
        'name',
        'title',
        'status',
        'description',
        'recipient_type',
        'title_service',
        'cta_name',
        'rgpd_mention',
        'confirmation_email_name',
    ];

    public function related(): HasMany
    {
        return $this->hasMany(Formable::class)
            ->orderBy('order')
        ;
    }

    public function fields(): BelongsToMany
    {
        return $this->morphedByMany(Field::class, 'formable')
            ->withPivot('order')
            ->orderBy('order')
        ;
    }

    public function titleFields(): BelongsToMany
    {
        return $this->morphedByMany(TitleField::class, 'formable')
            ->withPivot('order')
            ->orderBy('order')
        ;
    }

    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(Recipient::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class)
            ->withPivot('order')
            ->orderBy('order')
        ;
    }

    public function chargeFieldItems(): void
    {
        $fieldItems = collect();
        $fields = $this->fields;
        $titleFields = $this->titleFields;

        $fields->each(function ($field) use (&$fieldItems) {
            $field->formable_type = Field::class;
            $field->title = $field->field_name;
            $fieldItems->push($field);
        });
        $titleFields->each(function ($titleField) use (&$fieldItems) {
            $titleField->formable_type = TitleField::class;
            $fieldItems->push($titleField);
        });

        $fieldItems = $fieldItems->sortBy(function ($item) {
            return $item->pivot->order;
        });

        $this->field_items = $fieldItems;
    }
}
