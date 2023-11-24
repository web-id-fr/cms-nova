<?php

namespace Webid\CmsNova\App\Models\Components;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Webid\CmsNova\App\Models\Traits\DeleteRelationshipOnCascade;
use Webid\CmsNova\App\Models\Traits\HasStatus;

class TextComponent extends Model
{
    use HasStatus,
        DeleteRelationshipOnCascade,
        HasFactory;

    const _STATUS_PUBLISHED = 1;
    const _STATUS_DRAFT = 2;

    /**
     * The table associated with the model.
     *
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
