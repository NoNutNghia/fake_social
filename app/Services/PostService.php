<?php

namespace App\Services;

use App\Enum\ResponseCodeEnum;
use App\Helper\UploadImageHelper;
use App\Helper\UploadVideoHelper;
use App\Http\Requests\AddPostRequest;
use App\Models\ImagePost;
use App\Models\Post;
use App\Models\VideoPost;
use App\Response\Model\ResponseObject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $indexSort = 1;

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
}
