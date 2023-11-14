<?php

namespace App\Http\Middleware;

use App\Enum\ResponseCodeEnum;
use App\Enum\StatusUserEnum;
use App\Response\Model\ResponseObject;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthStatusCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->status_user != StatusUserEnum::ACTIVE) {
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_1009);

            return response()->json($responseError->toArray());
        }
        return $next($request);
    }
}
