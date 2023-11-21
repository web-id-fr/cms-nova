<?php

namespace Webid\CmsNova\Modules\Form\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;
use Webid\CmsNova\App\Models\Traits\HasFlexible;

/**
 * Class Field.
 *
 * @property string $field_name
 */
class Field extends Model
{
    use HasFactory;
    use HasFlexible;
    use HasTranslations;

    public array $translatable = [
        'placeholder',
        'field_options',
        'date_field_title',
        'date_field_placeholder',
        'time_field_title',
        'time_field_placeholder',
        'duration_field_title',
        'label',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fields';

    protected $fillable = [
        'field_options',
        'field_name',
        'field_type',
        'placeholder',
        'required',
        'date_field_title',
        'date_field_placeholder',
        'time_field_title',
        'time_field_placeholder',
        'duration_field_title',
        'field_name_time',
        'field_name_duration',
        'label',
    ];

    /**
     * @param string $value
     *
     * @return \Whitecube\NovaFlexibleContent\Layouts\Collection
     */
    public function getFieldOptionsAttribute($value)
    {
        return $this->toFlexible($value);
    }

    public function forms(): MorphToMany
    {
        return $this->morphToMany(Form::class, 'formable')
            ->withPivot('order')
        ;
    }
}
