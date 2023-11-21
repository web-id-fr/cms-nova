<?php

namespace Webid\CmsNova\Modules\JavaScript\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CodeSnippet.
 *
 * @property int $status
 */
class CodeSnippet extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'code_snippets';

    protected $fillable = [
        'name',
        'source_code',
    ];
}
