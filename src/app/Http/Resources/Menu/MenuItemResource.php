<?php

namespace Webid\CmsNova\App\Http\Resources\Menu;

use App\Models\Page;
use Illuminate\Http\Resources\Json\JsonResource;
use Webid\CmsNova\App\Models\Menu\MenuCustomItem;
use Webid\CmsNova\App\Models\Menu\MenuItem;
use Webid\CmsNova\Modules\Form\Http\Resources\FormResource;

class MenuItemResource extends JsonResource
{
    /** @var MenuItem */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        /** @var MenuCustomItem $menuable */
        $menuable = $this->resource->menuable;
        $children = $menuable->childrenForMenu($this->resource->menu_id);
        $full_path = '';

        if (Page::class == $this->resource->menuable_type) {
            /** @var Page $template */
            $template = $this->resource->menuable;
            $full_path = $template->getFullPath();
        }

        return [
            // Champs communs à tous les types
            'id' => $menuable->id,
            'title' => $menuable->title,
            'children' => MenuItemChildrenResource::collection($children)->resolve(),

            // Champs exclusifs aux Custom items
            $this->mergeWhen(MenuCustomItem::class == $this->resource->menuable_type, [
                $this->mergeWhen(MenuCustomItem::_LINK_FORM == $menuable->type_link, [
                    'form' => ! empty($menuable->form)
                        ? FormResource::make($menuable->form)->resolve()
                        : [],
                ]),
                $this->mergeWhen(MenuCustomItem::_LINK_URL == $menuable->type_link, [
                    'url' => $menuable->url,
                    'target' => $menuable->target,
                ]),
            ]),

            // Champs exclusifs aux Pages
            $this->mergeWhen(Page::class == $this->resource->menuable_type, [
                'slug' => $menuable->slug,
                'full_path' => "/{$full_path}",
            ]),
        ];
    }
}
