<?php

namespace Webid\CmsNova\Modules\Form\Nova;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Alexwenzel\DependencyContainer\HasDependencies;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\Form\Models\Form as FormModel;
use Webid\ConfirmationEmailItemField\ConfirmationEmailItemField;
use Webid\FieldItemField\FieldItemField;
use Webid\RecipientItemField\RecipientItemField;
use Webid\ServiceItemField\ServiceItemField;
use Webid\TranslatableItemField\Translatable;

class Form extends Resource
{
    use HasDependencies;

    /** @var FormModel */
    public $resource;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = FormModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * @return null|array|string
     */
    public static function label()
    {
        return __('Forms');
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Name'), 'name')
                ->rules('required'),

            Translatable::make(__('Title'), 'title')
                ->singleLine()
                ->rules('required'),

            Translatable::make(__('Description'), 'description')
                ->trix()
                ->rules('array')
                ->hideFromIndex()
                ->asHtml(),

            FieldItemField::make(__('Fields'), 'fields')
                ->hideFromIndex(),

            ConfirmationEmailItemField::make(__('Confirmation email field'), 'confirmation_email_name')
                ->canSee(function ($request) {
                    return config('form.send_email_confirmation');
                }),

            Translatable::make(__('CTA name'), 'cta_name')
                ->singleLine()
                ->rules('array', 'required')
                ->hideFromIndex(),

            Translatable::make(__('RGPD mention'), 'rgpd_mention')
                ->trix()
                ->rules('array')
                ->hideFromIndex()
                ->asHtml(),

            Select::make(__('Recipient type'), 'recipient_type')
                ->options(FormModel::TYPE_TO_SERVICE)
                ->rules('required')
                ->onlyOnForms(),

            DependencyContainer::make([
                RecipientItemField::make(__('Recipients'), 'recipients')
                    ->hideFromIndex(),
            ])->dependsOn('recipient_type', formModel::_RECIPIENTS),

            DependencyContainer::make([
                Translatable::make(__('Title service'), 'title_service')
                    ->singleLine(),

                ServiceItemField::make(__('Services'), 'services')
                    ->hideFromIndex(),
            ])->dependsOn('recipient_type', FormModel::_SERVICES),

            Select::make(__('Status'), 'status')
                ->options(FormModel::statusLabels())
                ->displayUsingLabels()
                ->rules('integer', 'required')
                ->hideFromIndex(),

            Boolean::make(__('Published'), function () {
                return $this->isPublished();
            })->onlyOnIndex(),
        ];
    }

    public function isPublished(): bool
    {
        return FormModel::_STATUS_PUBLISHED == $this->resource->status;
    }
}
