<?php

namespace Webid\CmsNova\Modules\Form\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'name',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'recipients',
    ];

    protected $fillable = [
        'name',
    ];

    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(Recipient::class);
    }
}
