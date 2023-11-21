<?php

namespace Webid\CmsNova\Modules\Form\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Formable extends Model
{
    public function formables(): MorphTo
    {
        return $this->morphTo('formable');
    }
}
