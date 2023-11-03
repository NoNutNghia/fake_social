<?php

namespace App\Http\Middleware;

use App\Enum\ResponseCodeEnum;
use App\Response\Model\ResponseObject;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class CheckConnectionDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            DB::connection()->getPDO();
            return $next($request);
        } catch (\Exception $e) {
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_1001);
            return response()->json(
                $responseError->toArray()
            );
        }
    }
}
