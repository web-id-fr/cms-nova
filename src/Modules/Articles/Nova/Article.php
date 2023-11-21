<?php

namespace Webid\CmsNova\Modules\Articles\Nova;

use Carbon\Carbon;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\Traits\HasTabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Resource;
use Oneduo\NovaFileManager\FileManager;
use Webid\ArticleCategoriesItemField\ArticleCategoriesItemField;
use Webid\CmsNova\App\Rules\TranslatableMax;
use Webid\CmsNova\App\Rules\TranslatableSlug;
use Webid\CmsNova\Modules\Articles\Models\Article as ArticleModel;
use Webid\CmsNova\Modules\Articles\Nova\Layouts\Preset\ArticlePreset;
use Webid\TranslatableItemField\Translatable;
use Whitecube\NovaFlexibleContent\Flexible;

class Article extends Resource
{
    use HasTabs;

    /** @var ArticleModel */
    public $resource;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ArticleModel::class;

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
    ];

    /**
     * @return null|array|string
     */
    public static function label()
    {
        return __('Articles');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function fields(Request $request)
    {
        return [
            Tabs::make(__(':resource Details: :title', [
                'resource' => self::singularLabel(),
                'title' => $this->title(),
            ]), [
                Tab::make(__('Parameters'), $this->parameterFields()),
                Tab::make(__('Content'), $this->contentFields()),
                Tab::make(__('Settings'), $this->seoFields()),
            ]),
        ];
    }

    public function isPublished(): bool
    {
        return ArticleModel::_STATUS_PUBLISHED == $this->resource->status
            && ($this->resource->publish_at <= Carbon::now() || null == $this->resource->publish_at);
    }

    protected function parameterFields(): array
    {
        return [
            ID::make()->sortable(),

            Translatable::make(__('Title'), 'title')
                ->singleLine()
                ->shortenText()
                ->rules('required')
                ->sortable(),

            Translatable::make(__('Slug'), 'slug')
                ->help(__('Please use only this type of slug "name-of-the-template"'))
                ->singleLine()
                ->hideFromIndex()
                ->rules('array', new TranslatableMax(100), new TranslatableSlug()),

            FileManager::make(__('Article image'), 'article_image')
                ->rules('required')
                ->hideFromIndex(),

            Translatable::make(__('Article image balise alt'), 'article_image_alt')
                ->singleLine()
                ->hideFromIndex(),

            ArticleCategoriesItemField::make(__('Categories'), 'categories')
                ->single(config('articles.single_category')),

            Number::make(__('Order'), 'order')
                ->min(0)->step(1),

            Boolean::make(__('Not display in list'), 'not_display_in_list')
                ->hideFromIndex(),

            Select::make(__('Status'), 'status')
                ->options(ArticleModel::statusLabels())
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

    /**
     * @throws \Exception
     */
    protected function contentFields(): array
    {
        return [
            Select::make(__('Article type'), 'article_type')
                ->options(ArticleModel::availableArticleTypes())
                ->displayUsingLabels()
                ->rules('integer', 'required')
                ->hideFromIndex(),

            Translatable::make(__('Excerpt'), 'extrait')
                ->trix()
                ->asHtml()
                ->rules('array')
                ->hideFromIndex(),

            Flexible::make(__('Content'), 'content')
                ->preset(ArticlePreset::class)
                ->hideFromIndex(),

            Translatable::make(__('Author'), 'author')
                ->singleLine()
                ->hideFromIndex(),
        ];
    }

    protected function seoFields(): array
    {
        return [
            Heading::make('Meta'),

            Translatable::make(__('Title'), 'metatitle')
                ->singleLine()
                ->hideFromIndex(),

            Translatable::make(__('Description'), 'metadescription')
                ->rules('array')
                ->hideFromIndex(),

            Heading::make('Open graph'),

            Translatable::make(__('Title'), 'opengraph_title')
                ->singleLine()
                ->hideFromIndex(),

            Translatable::make(__('Description'), 'opengraph_description')
                ->rules('array')
                ->hideFromIndex(),

            FileManager::make(__('Image'), 'opengraph_picture')
                ->hideFromIndex(),

            Translatable::make(__('Image balise alt'), 'opengraph_picture_alt')
                ->singleLine()
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
