<?php

namespace Spirit1086\Restfull;

use Spirit1086\Restfull\Http\Controllers\Controller;
use Spirit1086\Restfull\Traits\ApiMessage;
use Spirit1086\Restfull\Resources\{ApiCollection, ApiResource, ApiResponse, AuthResource};
use Illuminate\Http\Resources\Json\{ResourceCollection,JsonResource};

class ApiController extends Controller
{
    /**
     * @param object $data
     * @return ApiCollection
     */
    public function resourceCollection(object $data):ResourceCollection
    {
        return new ApiCollection($data);
    }

    /**
     * @param object|null $item
     * @param bool $is_delete
     * @return ApiResource|\Illuminate\Http\JsonResponse
     */
    public function resourceItem(?object $item):JsonResource
    {
        if($this->isNotFound($item))
        {
            return $this->notFoundResponse();
        }
        $is_delete = request()->isMethod('delete');
        if($is_delete)
        {
            $item->delete();
        }
        return new ApiResource($item);
    }

    /**
     * @param object $response
     * @return \Illuminate\Http\JsonResponse
     */
    private function sendResponse(object $response):JsonResource
    {
        return new ApiResponse($response);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function notFoundResponse():JsonResource
    {
        $response = ApiMessage::notFoundResponse();
        return $this->sendResponse($response);
    }

    private function notAuthorized():JsonResource
    {
        $response = ApiMessage::unAuth();
        return $this->sendResponse($response);
    }

    /**
     * @param object|null $item
     * @return bool
     */
    private function isNotFound(?object $item):bool
    {
        return (!$item) ? true : false;
    }

    /**
     * @param object|null $data
     * @return JsonResource
     */
    public function access(?object $data):JsonResource
    {
        if($data)
        {
            return new AuthResource($data);
        }
        return $this->notAuthorized();
    }
}
