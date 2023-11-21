<?php

namespace Webid\CmsNova\App\Models\Dummy;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Webid\CmsNova\App\Models\Traits\DeleteRelationshipOnCascade;
use Webid\CmsNova\App\Models\Traits\HasStatus;

/**
 * @property int    $status
 * @property string $name
 */
class DummyComponent extends Model
{
    use DeleteRelationshipOnCascade;
    use HasFactory;
    use HasStatus;

    public const _STATUS_PUBLISHED = 1;
    public const _STATUS_DRAFT = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dummy_components';

    protected $fillable = [
        'name',
        'status',
    ];

    public function templates(): MorphToMany
    {
        return $this->morphToMany(Template::class, 'component')
            ->withPivot('order')
        ;
    }
}
