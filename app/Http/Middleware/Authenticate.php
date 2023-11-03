<?php

namespace App\Http\Middleware;

use App\Enum\ResponseCodeEnum;
use App\Response\Model\ResponseObject;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('api/*')) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9998);
                return response()->json($responseError->toArray());
            }

            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return response()->json($responseError->toArray());
        }
    }
}
