<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Services\SignupService;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    private SignupService $signupService;

    /**
     * @param SignupService $signupService
     */
    public function __construct(SignupService $signupService)
    {
        $this->signupService = $signupService;
    }

    public function signup(SignupRequest $signupRequest)
    {
        return $this->signupService->signup($signupRequest);
    }
}
