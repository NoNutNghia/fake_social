<?php

namespace App\Exceptions;

use App\Enum\ResponseCodeEnum;
use App\Response\Model\ResponseObject;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (MethodNotAllowedHttpException $e) {
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9997);
            return response()->json($responseError->toArray());
        });

        $this->renderable(function (ThrottleRequestsException $e) {
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_1009);
            return response()->json($responseError->toArray());
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9998);
                return response()->json($responseError->toArray());
            }

            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return response()->json($responseError->toArray());
        });
    }
}
