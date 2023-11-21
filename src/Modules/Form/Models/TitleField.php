<?php

namespace Webid\CmsNova\Modules\Form\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TitleField extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'title',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'title_fields';

    protected $fillable = [
        'title',
    ];
}
