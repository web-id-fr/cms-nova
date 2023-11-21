<?php

namespace Webid\CmsNova\Modules\Form\Observers;

use Illuminate\Support\Str;
use Webid\CmsNova\Modules\Form\Models\Field;

class FieldObserver
{
    public function saving(Field $field): void
    {
        $field->field_name = Str::slug($field->field_name);
    }
}
