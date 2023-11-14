<?php

namespace App\Services;

use App\Enum\ResponseCodeEnum;
use App\Http\Requests\DeleteSavedSearchRequest;
use App\Http\Requests\GetSavedSearchRequest;
use App\Http\Requests\SearchPostRequest;
use App\Models\Search;
use App\Response\Model\ResponseObject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchService extends BaseService
{
    public function searchPost(SearchPostRequest $searchPostRequest)
    {
        $search = new Search();

        $search->keyword = $searchPostRequest->keyword;
        $search->user_id = $searchPostRequest->user_id;
        $search->created_at = Carbon::now();

        $search->save();
    }

    public function getSavedSearch(GetSavedSearchRequest $getSavedSearchRequest)
    {
        $savedSearch = Search::where('user_id', Auth::user()->id)
            ->offset($getSavedSearchRequest->index)
            ->limit($getSavedSearchRequest->count)
            ->get();

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $savedSearch->toArray());

        return $this->responseData($response);
    }

    public function deleteSavedSearch(DeleteSavedSearchRequest $deleteSavedSearchRequest)
    {
        try {
            DB::beginTransaction();
            if (!$deleteSavedSearchRequest->all) {
                Search::where('id', $deleteSavedSearchRequest->search_id)->delete();
            } else {
                Search::where('user_id', Auth::user()->id)->delete();
            }

            DB::commit();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000);

            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

//    public function

//    public function
}
