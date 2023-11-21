<?php

namespace Webid\CmsNova\Modules\Slideshow\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Spatie\Translatable\HasTranslations;

/**
 * Class Slideshow.
 *
 * @property Collection $slides
 */
class Slideshow extends Model
{
    use HasFactory;
    use HasTranslations;

    public Collection $slide_items;

    public array $translatable = [
        'title',
    ];

    /** @var string */
    protected $table = 'slideshows';

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'slides',
    ];

    protected $fillable = [
        'title',
        'js_controls',
        'js_animate_auto',
        'js_speed',
    ];

    public function slides(): BelongsToMany
    {
        return $this->belongsToMany(Slide::class)
            ->withPivot('order')
            ->orderBy('order')
        ;
    }

    public function setJsSpeedAttribute(?string $value): void
    {
        if (! $value) {
            $this->attributes['js_speed'] = 5000;
        } else {
            $this->attributes['js_speed'] = intval($value) * 1000;
        }
    }

    public function chargeSlideItems(): void
    {
        $slideItems = collect();
        $slides = $this->slides;

        $slides->each(function ($slide) use (&$slideItems) {
            if (! empty($slide->image)) {
                $slide->imageAsset = config('cms.image_path') . $slide->image->path;
            }
            $slideItems->push($slide);
        });

        $this->slide_items = $slideItems;
    }
}
