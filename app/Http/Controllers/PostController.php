<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPostRequest;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private PostService $postService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function addPost(AddPostRequest $addPostRequest)
    {
        return $this->postService->addPost($addPostRequest);
    }
}
