<?php

namespace Webid\CmsNova\App\Models\Components;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Webid\CmsNova\App\Models\Traits\DeleteRelationshipOnCascade;

class BreadcrumbComponent extends Model
{
    use DeleteRelationshipOnCascade;
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'breadcrumb_components';

    protected $fillable = [
        'name',
    ];

    public function templates(): MorphToMany
    {
        return $this->morphToMany(Template::class, 'component')
            ->withPivot('order')
        ;
    }
}
