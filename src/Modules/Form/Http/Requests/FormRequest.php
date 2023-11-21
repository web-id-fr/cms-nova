<?php

namespace Webid\CmsNova\Modules\Form\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseRequest;
use Webid\CmsNova\Modules\Form\Models\Field;
use Webid\CmsNova\Modules\Form\Repositories\FormRepository;

class FormRequest extends BaseRequest
{
    public function __construct(
        private FormRepository $formRepository,
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function constructRulesArray(): array
    {
        $fields_rules = [];

        if ($this->request->get('form_id')) {
            /** @var int $id */
            $id = intval($this->request->get('form_id'));
            $form = $this->formRepository->find($id);
        } else {
            $fields_rules['form_id'] = 'integer|required';

            return $fields_rules;
        }

        foreach ($form->related as $field) {
            if (Field::class == $field->formable_type) {
                $field_type = $field->formable->field_type;
                $field_type = config("fields_type.{$field_type}");
                if (array_key_exists($field_type, config('fields_type_validation'))) {
                    if ($field->formable->required) {
                        $rules = config("fields_type_validation.{$field_type}") . '|required';
                    } else {
                        $rules = 'nullable|' . config("fields_type_validation.{$field_type}");
                    }
                    $fields_rules[$field->formable->field_name] = $rules;
                } else {
                    if ($field->formable->required) {
                        $fields_rules[$field->formable->field_name] = 'required';
                    }
                }
            }
        }

        return $fields_rules;
    }

    public function rules(): array
    {
        return $this->constructRulesArray();
    }
}
