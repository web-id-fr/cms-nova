<?php

namespace Webid\CmsNova\App\Nova;

use App\Models\Page as PageModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Oneduo\NovaFileManager\FileManager;
use Webid\CmsNova\App\Repositories\PageRepository;
use Webid\CmsNova\App\Rules\TranslatableMax;
use Webid\CmsNova\App\Rules\TranslatableSlug;
use Webid\ComponentItemField\ComponentItemField;
use Webid\PageUrlItemField\PageUrlItemField;

class Page extends Resource
{
    /** @var PageModel */
    public $resource;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PageModel::class;

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
        'title',
        'slug',
    ];

    public function title()
    {
        /** @var string $title */
        $title = $this->resource->title;

        /** @var string $slug */
        $slug = $this->resource->slug;

        return "{$title} - {$slug}";
    }

    /**
     * @return null|array|string
     */
    public static function label()
    {
        return __('Pages');
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function fields(Request $request)
    {
        return [
            ...$this->parameterFields(),
            ...$this->contentFields(),
            ...$this->seoFields(),
        ];
    }

    public function getFullUrl(): array
    {
        $urls = [];

        URL::to($this->resource->getFullPath());

        return $urls;
    }

    public function getParentPageId(): int
    {
        if (! empty($this->resource->parent_page_id)) {
            return $this->resource->parent_page_id;
        }

        $pageRepository = app(PageRepository::class);
        $homepageId = $pageRepository->getIdForHomepage();

        if (! empty($homepageId) && ! $this->resource->homepage) {
            return $homepageId->getKey();
        }

        return 0;
    }

    public function isPublished(): bool
    {
        return PageModel::_STATUS_PUBLISHED == $this->resource->status
            && ($this->resource->publish_at <= Carbon::now() || null == $this->resource->publish_at);
    }

    /**
     * @throws \Exception
     */
    protected function parameterFields(): array
    {
        return [
            ID::make()->sortable(),

            Boolean::make(__('Homepage'), 'homepage'),

            Text::make(__('Title'), 'title')
                ->rules('required')
                ->sortable(),

            Text::make(__('Menu description'), 'menu_description')
                ->help(__(
                    'This field is optional and allows you to add a short description below the title in the sub-menu.'
                ))
                ->hideFromIndex()
                ->sortable(),

            Text::make(__('Slug'), 'slug')
                ->help(__('Please use only this type of slug "name-of-the-template"'))
                ->rules('array', new TranslatableMax(100), new TranslatableSlug())
                ->onlyOnForms(),

            PageUrlItemField::make('Url', 'slug')
                ->url($this->getFullUrl())
                ->showOnIndex()
                ->showOnDetail()
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            BelongsTo::make(__('Parent page'), 'parent', Page::class)
                ->withMeta([
                    'belongsToId' => $this->getParentPageId(),
                ])->nullable()
                ->searchable(),

            Select::make(__('Status'), 'status')
                ->options(PageModel::statusLabels())
                ->displayUsingLabels()
                ->rules('integer', 'required')
                ->hideFromIndex(),

            DateTime::make(__('Publish at'), 'publish_at')
                ->hideFromIndex(),

            Boolean::make(__('Published'), function () {
                return $this->isPublished();
            })->onlyOnIndex(),
        ];
    }

    protected function contentFields(): array
    {
        return [
            ComponentItemField::make(__('Components'), 'components')
                ->hideFromIndex(),
        ];
    }

    protected function seoFields(): array
    {
        return [
            BelongsTo::make(__('Reference page'), 'referencePage', Page::class)
                ->nullable()
                ->searchable(),

            Heading::make('Meta'),

            Text::make(__('Title'), 'metatitle')
                ->hideFromIndex(),

            Text::make(__('Description'), 'metadescription')
                ->asHtml()
                ->rules('array')
                ->hideFromIndex(),

            Text::make(__('Keywords'), 'meta_keywords')
                ->rules('array')
                ->hideFromIndex(),

            Heading::make('Open graph'),

            Text::make(__('Title'), 'opengraph_title')
                ->hideFromIndex(),

            Text::make(__('Description'), 'opengraph_description')
                ->asHtml()
                ->rules('array')
                ->hideFromIndex(),

            FileManager::make(__('Image'), 'opengraph_picture')
                ->hideFromIndex(),

            Text::make(__('Image balise alt'), 'opengraph_picture_alt')
                ->hideFromIndex(),

            Heading::make(__('Indexation')),

            Boolean::make(__('Index the page'), 'indexation')
                ->withMeta([
                    'value' => data_get($this, 'indexation', true),
                ])->hideFromIndex(),

            Boolean::make(__('Follow the page'), 'follow')
                ->withMeta([
                    'value' => data_get($this, 'follow', true),
                ])->hideFromIndex(),
        ];
    }
}
