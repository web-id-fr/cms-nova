<?php

namespace Webid\CmsNova\Modules\Components\TextComponent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Webid\CmsNova\App\Models\Traits\DeleteRelationshipOnCascade;
use Webid\CmsNova\App\Models\Traits\HasStatus;
use Webid\CmsNova\App\Nova\Page;

class TextComponent extends Model
{
    use HasStatus,
        DeleteRelationshipOnCascade,
        HasFactory;

    const _STATUS_PUBLISHED = 1;
    const _STATUS_DRAFT = 2;

    /**
     * @var string
     */
    protected $table = 'text_components';

    protected $fillable = [
        'name',
        'status',
    ];

    public function pages(): MorphToMany
    {
        return $this->morphToMany(Page::class, 'component')
            ->withPivot('order');
    }
}
