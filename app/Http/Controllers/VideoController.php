<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetListVideosRequest;
use App\Services\VideoService;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    private VideoService $videoService;

    /**
     * @param VideoService $videoService
     */
    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function getListVideos(GetListVideosRequest $getListVideosRequest)
    {
        return $this->videoService->getListVideos($getListVideosRequest);
    }
}
