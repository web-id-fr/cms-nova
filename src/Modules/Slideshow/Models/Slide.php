<?php

namespace Webid\CmsNova\Modules\Slideshow\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Oneduo\NovaFileManager\Casts\Asset;
use Spatie\Translatable\HasTranslations;

class Slide extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'title',
        'description',
        'url',
        'cta_name',
        'cta_url',
        'image_alt',
    ];

    /** @var string */
    protected $table = 'slides';

    protected $fillable = [
        'title',
        'description',
        'image',
        'image_alt',
        'url',
        'cta_name',
        'cta_url',
    ];

    protected $casts = [
        'image' => Asset::class,
    ];

    public function slideshows(): BelongsToMany
    {
        return $this->belongsToMany(Slideshow::class)
            ->withPivot('order')
        ;
    }
}
