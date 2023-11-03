<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckVerifyCodeRequest;
use App\Http\Requests\GetVerifyCodeRequest;
use App\Services\VerifyCodeService;
use Illuminate\Http\Request;

class VerifyCodeController extends Controller
{

    private VerifyCodeService $verifyCodeService;

    /**
     * @param VerifyCodeService $verifyCodeService
     */
    public function __construct(VerifyCodeService $verifyCodeService)
    {
        $this->verifyCodeService = $verifyCodeService;
    }

    public function getVerifyCode(GetVerifyCodeRequest $getVerifyCodeRequest)
    {
        return $this->verifyCodeService->getVerifyCode($getVerifyCodeRequest);
    }

    public function checkVerifyCode(CheckVerifyCodeRequest $checkVerifyCodeRequest)
    {
        return $this->verifyCodeService->checkVerifyCode($checkVerifyCodeRequest);
    }
}
