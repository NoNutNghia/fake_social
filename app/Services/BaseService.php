<?php

namespace App\Services;

use App\Response\Model\ResponseObject;

class BaseService
{
    protected function responseData(ResponseObject $responseObject): \Illuminate\Http\JsonResponse
    {
        return response()->json($responseObject->toArray());
    }
}
