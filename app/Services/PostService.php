<?php

namespace App\Services;

use App\Enum\MarkTypeEnum;
use App\Enum\PostStatusEnum;
use App\Enum\RatingPostEnum;
use App\Enum\ResponseCodeEnum;
use App\Enum\StatusUserEnum;
use App\Helper\UploadImageHelper;
use App\Helper\UploadVideoHelper;
use App\Http\Requests\AddPostRequest;
use App\Http\Requests\CheckNewItemsRequest;
use App\Http\Requests\DeletePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Http\Requests\FeelRequest;
use App\Http\Requests\GetListPostsRequest;
use App\Http\Requests\GetMarkCommentRequest;
use App\Http\Requests\GetPostRequest;
use App\Http\Requests\ReportPostRequest;
use App\Http\Requests\SetMarkCommentRequest;
use App\Models\Comment;
use App\Models\ImagePost;
use App\Models\Mark;
use App\Models\Post;
use App\Models\RatingPost;
use App\Models\ReportPost;
use App\Models\VideoPost;
use App\Response\Model\ResponseObject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PostService extends BaseService
{
    public function addPost(AddPostRequest $addPostRequest)
    {
        try {

            DB::beginTransaction();

            if (Auth::user()->coins < 10) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9991);

                return $this->responseData($responseError);
            }

            $post = new Post();
            $post->described = $addPostRequest->described ?: "";
            $post->status = $addPostRequest->status ?: "";
            $post->user_id = Auth::user()->id;

            $post->save();

            $checkImageFile = $addPostRequest->hasFile('image');
            $checkVideoFile = $addPostRequest->hasFile('video');

            $indexSort = 0;

            if ($checkImageFile) {
                $imageList = array();
                $fileList = $addPostRequest->file('image');

                foreach ($fileList as $file) {
                    $result = UploadImageHelper::uploadImage($file, $post->id, $indexSort);

                    if ($result) {
                        array_push($imageList, array(
                            "post_id" => $post->id,
                            "url" => $result,
                            "sort_index" => $indexSort,
                            "created_at" => Carbon::now(),
                        ));
                    }

                    $indexSort++;
                }

                ImagePost::upsert($imageList, ["post_id", "url", "sort_index", "created_at"]);
            }

            if ($checkVideoFile && !$checkImageFile) {
                $videoList = array();
                $fileList = $addPostRequest->file('video');

                foreach ($fileList as $file) {
                    $result = UploadVideoHelper::uploadVideo($file, $post->id, $indexSort);

                    if ($result) {
                        array_push($videoList, array(
                            "post_id" => $post->id,
                            "url" => $result,
                            "sort_index" => $indexSort,
                            "created_at" => Carbon::now(),
                        ));
                    }
                }

                VideoPost::upsert($videoList, ["post_id", "url", "sort_index", "created_at"]);
            }

            Auth::user()->decrement('coins', 10);

            DB::commit();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000);

            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function getPost(GetPostRequest $getPostRequest)
    {
        $post = Post::where('id', $getPostRequest->id)->first();

        if (!$post) {
            $response = new ResponseObject(ResponseCodeEnum::CODE_1000);
            return $this->responseData($response);
        }

        if ($post->post_status == PostStatusEnum::BLOCKED_POST) {
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9992);
            return $this->responseData($responseError);
        }

        $checkBlock = $post->authorPost->list_user_blocked->pluck('user_blocked_id')->contains(function ($value, $key) {
            return $value == Auth::user()->id;
        });

        $checkEdit = $post->authorPost->id == Auth::user()->id;

        $ratingList = $post->haveRating;
        $markList = $post->haveMark;
        $post->image;
        $post->video;

        $post = collect($post);

        $post['is_blocked'] = 0;
        $post['is_rate'] = 0;

        if ($checkBlock) {
            $post->transform(function ($item, $key) {
                return "";
            });
            $post['is_blocked'] = 1;
            $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $post->toArray());
            return $this->responseData($response);
        }

        if (!$ratingList->pluck('user_id')->contains(Auth::user()->id)) {
            $post["is_rate"] = 1;
        }

        $ratingCountList = $ratingList->countBy('rating');
        $markCountList = $markList->countBy('type_of_mark');

        $post['fake'] = $markCountList[MarkTypeEnum::FAKE] ?? 0;
        $post['trues'] = $markCountList[MarkTypeEnum::TRUST] ?? 0;
        $post['kudos'] = $ratingCountList[RatingPostEnum::KUDOS] ?? 0;
        $post['disappointed'] = $ratingCountList[RatingPostEnum::DISAPPOINTED] ?? 0;

        $post['can_edit'] = $checkEdit ? 1 : 0;
        $post['url'] = URL::current();

        $post->forget('have_rating');
        $post->forget('have_mark');

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $post->toArray());

        return $this->responseData($response);
    }

    public function editPost(EditPostRequest $editPostRequest)
    {
        try {
            DB::beginTransaction();
            $post = Post::where('id', $editPostRequest->id)->first();

            if (!$post) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9992);
                return $this->responseData($responseError);
            }

            if ($post->user_id != Auth::user()->id) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_1009);
                return $this->responseData($responseError);
            }

            if ($editPostRequest->image_del) {
                $imageList = $post->image;

                foreach ($imageList as $image) {
                    $resultDelete = UploadImageHelper::deleteImage($image->url);
                    if ($resultDelete) $image->delete();
                }
            }

            if ($editPostRequest->image_sort && $editPostRequest->hasFile('image')) {
                $count = 0;
                $imageArray = [];

                foreach ($editPostRequest->file('image') as $imageItem) {
                    $result = UploadImageHelper::uploadImage($imageItem, $post->id, $editPostRequest->image_sort[$count]);

                    if ($result) {
                        array_push($imageArray, array(
                            "post_id" => $post->id,
                            "url" => $result,
                            "sort_index" => $editPostRequest->image_sort[$count],
                            "created_at" => Carbon::now(),
                        ));
                    }
                    $count++;
                }

                ImagePost::upsert($imageArray, ["post_id", "url", "sort_index", "created_at"]);
            }

            if ($editPostRequest->hasFile('video')) {
                $video = $editPostRequest->file('video');

                $result = UploadVideoHelper::uploadVideo($video, $post->id);

                if ($result) {
                    $video = new VideoPost();
                    $video->post_id = $post->id;
                    $video->url = $result;
                    $video->sort_index = 0;
                    $video->created_at = Carbon::now();

                    $video->save();
                }
            }

            $post->described = $editPostRequest->described ?? "";
            $post->status = $editPostRequest->status ?? "";

            $post->save();

            Auth::user()->decrement('coins', 10);

            DB::commit();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000, ["coins" => Auth::user()->coins]);
            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function deletePost(DeletePostRequest $deletePostRequest)
    {
        try {
            DB::beginTransaction();

            $foundPost = Post::where('id', $deletePostRequest->id)->first();

            if (!$foundPost) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9992);

                return $this->responseData($responseError);
            }

            if ($foundPost->authorPost->id != Auth::user()->id) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9998);

                return $this->responseData($responseError);
            }
            $foundPost->delete();
            Storage::deleteDirectory("public/post/" . $deletePostRequest->id);
            Auth::user()->decrement('coins', 10);
            DB::commit();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000);

            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function reportPost(ReportPostRequest $reportPostRequest)
    {
        try {
            DB::beginTransaction();
            $foundPost = Post::where('id', $reportPostRequest->id)->first();

            if (!$foundPost) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9992);

                return $this->responseData($responseError);
            }

            if ($foundPost->post_status == PostStatusEnum::BLOCKED_POST) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_1010);

                return $this->responseData($responseError);
            }

            $reportPost = new ReportPost();
            $reportPost->details = $reportPostRequest->details;
            $reportPost->subject = $reportPostRequest->subject;
            $reportPost->user_id = Auth::user()->id;
            $reportPost->post_id = $foundPost->id;
            $reportPost->created_at = Carbon::now();

            $reportPost->save();

            DB::commit();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000);

            return $this->responseData($response);
        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function feel(FeelRequest $feelRequest)
    {
        try {
            DB::beginTransaction();
            $foundPost = Post::where('id', $feelRequest->id)->first();

            if (!$foundPost) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9992);

                return $this->responseData($responseError);
            }

            if ($foundPost->post_status == PostStatusEnum::BLOCKED_POST) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_1010);

                return $this->responseData($responseError);
            }

            $foundRating = RatingPost::where('user_id', Auth::user()->id)
                ->where('post_id', $feelRequest->id)
                ->first();

            $type = $feelRequest->type == 0 ? RatingPostEnum::DISAPPOINTED : RatingPostEnum::KUDOS;

            if ($foundRating) {
                $foundRating->rating = $type;

                $foundRating->save();
            } else {
                $ratingPost = new RatingPost();
                $ratingPost->user_id = Auth::user()->id;
                $ratingPost->rating = $type;
                $ratingPost->post_id = $feelRequest->id;
                $ratingPost->created_at = Carbon::now();

                $ratingPost->save();
            }

            DB::commit();

            $ratingList = $foundPost->haveRating->countBy('rating');

            $kudos = $ratingList[RatingPostEnum::KUDOS] ?? 0;
            $disappointed = $ratingList[RatingPostEnum::DISAPPOINTED] ?? 0;

            $data = array(
                'kudos' => $kudos,
                'disappointed' => $disappointed
            );

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);

            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function getMarkComment(GetMarkCommentRequest $getMarkCommentRequest)
    {
        $post = Post::where('id', $getMarkCommentRequest->id)->first();

        if (!$post) {
            $response = new ResponseObject(ResponseCodeEnum::CODE_1000);
            return $this->responseData($response);
        }

        if ($post->post_status == PostStatusEnum::BLOCKED_POST) {
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9992);
            return $this->responseData($responseError);
        }

        $listMark = $post->haveMark->makeHidden(['user_id', 'post_id'])->each(function ($mark, $key) use ($getMarkCommentRequest) {
            $poster = $mark->poster->makeHidden(['coins']);

            $mark['is_blocked'] = 0;

            if ($poster->status_user != StatusUserEnum::ACTIVE) {
                $mark['is_blocked'] = 1;
            }

            $comments = Comment::where('mark_id', $mark->id)
                ->offset($getMarkCommentRequest->index)
                ->limit($getMarkCommentRequest->count)
                ->get()
                ->makeHidden(['user_id', 'mark_id', 'id'])
                ->each(function ($comment, $key) {
                    $comment->poster->makeHidden(['coins']);
                });

            $mark['comments'] = $comments;
        });

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $listMark->toArray());

        return $this->responseData($response);
    }

    public function setMarkComment(SetMarkCommentRequest $setMarkCommentRequest)
    {
        try {
            DB::beginTransaction();

            $post = Post::where('id', $setMarkCommentRequest->id)->first();

            if (!$post) {
                $response = new ResponseObject(ResponseCodeEnum::CODE_1000);
                return $this->responseData($response);
            }

            if ($post->post_status == PostStatusEnum::BLOCKED_POST) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9992);
                return $this->responseData($responseError);
            }

            $user_id = Auth::user()->id;

            if ($setMarkCommentRequest->mark_id) {

                $mark = Mark::where('id', $setMarkCommentRequest->mark_id)->first();

                if (!$mark) {
                    $responseError = new ResponseObject(ResponseCodeEnum::CODE_9994);
                    return $this->responseData($responseError);
                }

                $comment = new Comment();
                $comment->content = $setMarkCommentRequest->content_request;
                $comment->mark_id = $setMarkCommentRequest->mark_id;
                $comment->user_id = $user_id;
                $comment->created_at = Carbon::now();

                $comment->save();
            } else {
                $mark = new Mark();
                $mark->user_id = $user_id;
                $mark->post_id = $setMarkCommentRequest->id;
                $mark->type_of_mark = $setMarkCommentRequest->type;
                $mark->mark_content = $setMarkCommentRequest->content_request;
                $mark->created_at = Carbon::now();

                $mark->save();
            }

            DB::commit();

        $listMark = $post->haveMark->makeHidden(['user_id', 'post_id'])->each(function ($mark, $key) use ($setMarkCommentRequest) {
            $poster = $mark->poster->makeHidden(['coins']);
            $mark['is_blocked'] = 0;

            if ($poster->status_user != StatusUserEnum::ACTIVE) {
                $mark['is_blocked'] = 1;
            }

            $comments = Comment::where('mark_id', $mark->id)
                ->offset($setMarkCommentRequest->index)
                ->limit($setMarkCommentRequest->count)
                ->get()
                ->makeHidden(['user_id', 'mark_id', 'id'])
                ->each(function ($comment, $key) {
                    $comment->poster->makeHidden(['coins']);
                });

            $mark['comments'] = $comments;
        });

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $listMark->toArray());

            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function getListPosts(GetListPostsRequest $getListPostsRequest)
    {
        if (isset($getListPostsRequest->index) && isset($getListPostsRequest->count)) {
            $listPost = Post::where('id', '>=', $getListPostsRequest->last_id)
                ->offset($getListPostsRequest->index)
                ->limit($getListPostsRequest->count)
                ->get();
        } else {
            $listPost = Post::where('id', '>=', $getListPostsRequest->last_id)->orderByDesc('id')->limit(20)->get();
        }

        foreach ($listPost as $post) {
            $checkBlock = $post->authorPost->list_user_blocked->pluck('user_blocked_id')->contains(function ($value, $key) {
                return $value == Auth::user()->id;
            });

            $checkEdit = $post->authorPost->id == Auth::user()->id;

            $ratingList = $post->haveRating;
            $markList = $post->haveMark;
            $post->image;
            $post->video;

            $countCommentMark = 0;

            $post = collect($post);

            foreach ($markList as $mark) {
                $countCommentMark += $mark->comments->count();
            }

            $post['is_blocked'] = 0;
            $post['is_rate'] = 0;

            if (!$ratingList->pluck('user_id')->contains(Auth::user()->id)) {
                $post["is_felt"] = 1;
            }

            $ratingCount = $ratingList->count();
            $countCommentMark += $markList->count();

            $post['feel'] = $ratingCount;
            $post['comment_mark'] = $countCommentMark;

            $post['can_edit'] = $checkEdit ? 1 : 0;
            $post['url'] = URL::current();

            $post->forget('have_rating');
            $post->forget('have_mark');

            if ($checkBlock) {
                $post->transform(function ($item, $key) {
                    return "";
                });
                $post['is_blocked'] = 1;
            }
        }

        $lastItem = Post::orderByDesc('id')->first();
        $newItem = Post::whereBetween('id', [$listPost->first()->id, $lastItem->id])->get()->count() - 1;

        $data = [
            'post' => $listPost,
            'last_id' => $lastItem->id,
            'new_items' => $newItem,
        ];

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);

        return $this->responseData($response);
    }

    public function checkNewItems(CheckNewItemsRequest $checkNewItemsRequest)
    {
        $lastItem = Post::orderByDesc('id')->first();
        $countNewItems = Post::whereBetween('id', [$checkNewItemsRequest->last_id, $lastItem->id])->get()->count() - 1;

        $data = [
            "new_items" => max($countNewItems, 0),
        ];

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);
        return $this->responseData($response);
    }

//    private function checkCanRate($authorPost, ) {
//
//    }
}
