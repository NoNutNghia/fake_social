<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPostRequest;
use App\Http\Requests\CheckNewItemsRequest;
use App\Http\Requests\CheckNewVersionRequest;
use App\Http\Requests\DeletePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Http\Requests\FeelRequest;
use App\Http\Requests\GetListPostsRequest;
use App\Http\Requests\GetMarkCommentRequest;
use App\Http\Requests\GetPostRequest;
use App\Http\Requests\ReportPostRequest;
use App\Http\Requests\SetMarkCommentRequest;
use App\Services\PostService;

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

    public function getPost(GetPostRequest $getPostRequest)
    {
        return $this->postService->getPost($getPostRequest);
    }

    public function editPost(EditPostRequest $editPostRequest)
    {
        return $this->postService->editPost($editPostRequest);
    }

    public function deletePost(DeletePostRequest $deletePostRequest)
    {
        return $this->postService->deletePost($deletePostRequest);
    }

    public function reportPost(ReportPostRequest $reportPostRequest)
    {
        return $this->postService->reportPost($reportPostRequest);
    }

    public function feel(FeelRequest $feelRequest)
    {
        return $this->postService->feel($feelRequest);
    }

    public function getMarkComment(GetMarkCommentRequest $getMarkCommentRequest)
    {
        return $this->postService->getMarkComment($getMarkCommentRequest);
    }

    public function setMarkComment(SetMarkCommentRequest $setMarkCommentRequest)
    {
        return $this->postService->setMarkComment($setMarkCommentRequest);
    }

    public function getListPosts(GetListPostsRequest $getListPostsRequest)
    {
        return $this->postService->getListPosts($getListPostsRequest);
    }

    public function checkNewItems(CheckNewItemsRequest $checkNewItemsRequest)
    {
        return $this->postService->checkNewItems($checkNewItemsRequest);
    }
}
