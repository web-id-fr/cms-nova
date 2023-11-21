<?php

namespace Webid\CmsNova\App\Nova\Popin;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Alexwenzel\DependencyContainer\HasDependencies;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\Traits\HasTabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Oneduo\NovaFileManager\FileManager;
use Webid\AdvancedUrlField\AdvancedUrlField;
use Webid\CmsNova\App\Models\Popin\Popin as PopinModel;
use Webid\TemplateItemField\TemplateItemField;
use Webid\TranslatableItemField\Translatable;

class Popin extends Resource
{
    use HasDependencies;
    use HasTabs;

    /** @var PopinModel */
    public $resource;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PopinModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
    ];

    /**
     * @return null|array|string
     */
    public static function label()
    {
        return __('Popins');
    }

    public function fields(Request $request): array
    {
        return [
            Tabs::make(__(':resource Details: :title', [
                'resource' => self::singularLabel(),
                'title' => $this->title(),
            ]), [
                Tab::make(__('Parameters'), $this->parametersTab()),
                Tab::make(__('Content'), $this->contentTab()),
                Tab::make(__('Settings'), $this->settingsTab()),
            ]),
        ];
    }

    public function isPublished(): bool
    {
        return PopinModel::_STATUS_PUBLISHED == $this->resource->status;
    }

    protected function parametersTab(): array
    {
        return [
            Translatable::make(__('Title'), 'title')
                ->singleLine()
                ->sortable()
                ->rules('nullable', 'max:255'),

            TemplateItemField::make(__('Templates')),

            Select::make(__('Status'), 'status')
                ->options(PopinModel::statusLabels())
                ->displayUsingLabels()
                ->rules('required', 'integer')
                ->hideFromIndex(),

            Boolean::make(__('Published'), function () {
                return $this->isPublished();
            })->onlyOnIndex(),
        ];
    }

    protected function contentTab(): array
    {
        return [
            FileManager::make(__('Image'), 'image'),

            Translatable::make(__('Image balise alt'), 'image_alt')
                ->singleLine()
                ->hideFromIndex(),

            Translatable::make(__('Description'), 'description')
                ->trix()
                ->asHtml()
                ->hideFromIndex(),

            Boolean::make(__('Display a call-to-action'), 'display_call_to_action')
                ->hideFromIndex(),

            DependencyContainer::make([
                Translatable::make(__('CTA title'), 'button_1_title')
                    ->singleLine()
                    ->hideFromIndex(),

                AdvancedUrlField::make(__('CTA link'), 'button_1_url')
                    ->hideFromIndex(),
            ])->dependsOn('display_call_to_action', true),

            Boolean::make(__('Display a second call-to-action'), 'display_second_button')
                ->hideFromIndex(),

            DependencyContainer::make([
                Translatable::make(__('CTA title 2'), 'button_2_title')
                    ->singleLine()
                    ->hideFromIndex(),

                AdvancedUrlField::make(__('CTA link 2'), 'button_2_url')
                    ->hideFromIndex(),
            ])->dependsOn('display_second_button', true),
        ];
    }

    protected function settingsTab(): array
    {
        return [
            Select::make(__('Opening rule'), 'type')
                ->options([
                    'auto' => __('Timer after loading the page'),
                    'focus' => __('Exit popin'),
                ])
                ->displayUsingLabels()
                ->rules('required', 'string'),

            DependencyContainer::make([
                Number::make(__('Delay before displaying the popin (in seconds)'), 'delay')
                    ->hideFromIndex(),
            ])->dependsOn('type', 'auto'),

            DependencyContainer::make([
                Text::make(__('Button name'), 'button_name')
                    ->hideFromIndex(),
            ])->dependsOn('type', 'button'),

            Boolean::make(__('Display on mobile'), 'mobile_display')
                ->hideFromIndex(),

            Number::make(__('Max Display'), 'max_display')->min(1)->step(1)->nullable(),
        ];
    }
}
