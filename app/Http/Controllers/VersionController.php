<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckNewVersionRequest;
use App\Services\VersionService;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    private VersionService $versionService;

    /**
     * @param VersionService $versionService
     */
    public function __construct(VersionService $versionService)
    {
        $this->versionService = $versionService;
    }

    public function checkNewVersion(CheckNewVersionRequest $checkNewVersionRequest)
    {
        return $this->versionService->checkNewVersion($checkNewVersionRequest);
    }
}
