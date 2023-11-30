<?php

namespace Webid\CmsNova\App\Models\Components;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Webid\CmsNova\App\Models\Traits\DeleteRelationshipOnCascade;
use Webid\CmsNova\App\Models\Traits\HasStatus;
use Webid\CmsNova\Modules\JavaScript\Models\CodeSnippet;

/**
 * Class CodeSnippetComponent.
 *
 * @property int $status
 */
class CodeSnippetComponent extends Model
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
    protected $table = 'code_snippets_components';

    protected $fillable = [
        'name',
        'status',
        'code_snippet_id',
    ];

    public function codeSnippet(): BelongsTo
    {
        return $this->belongsTo(CodeSnippet::class);
    }

    public function templates(): MorphToMany
    {
        return $this->morphToMany(Page::class, 'component')
            ->withPivot('order')
        ;
    }
}
