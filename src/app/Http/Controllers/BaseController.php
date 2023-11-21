<?php

namespace Webid\CmsNova\App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected function jsonSuccess(
        string $message = 'Success',
        array $data = [],
        bool $isSuccess = true,
        int $status = 200
    ): JsonResponse {
        return response()->json([
            'success' => $isSuccess,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    protected function resourceToArray(JsonResource $resource): array
    {
        return $resource->response()->getData(true);
    }
}
