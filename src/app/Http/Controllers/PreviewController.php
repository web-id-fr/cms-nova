<?php

namespace Webid\CmsNova\App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PreviewController extends BaseController
{
    public function preview(Request $request): Factory|View
    {
        try {
            $components = [];
            $token = $request->token;
            $data = session($token);

            foreach (data_get($data, 'components') as $component) {
                $model = app($component['component_type'])::find($component['id']);
                $resource = config('components.' . $component['component_type'] . '.resource');
                $dataResource = $resource::make((object) ['component' => $model])->resolve();
                $dataResource['view'] = config('components.' . data_get($component, 'component_type') . '.view');
                $components[] = $dataResource;
            }

            $data['components'] = $components;

            return view('preview', ['data' => $data]);
        } catch (\Throwable $exception) {
            abort(404);
        }
    }
}
