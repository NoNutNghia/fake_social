<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteSavedSearchRequest;
use App\Http\Requests\GetSavedSearchRequest;
use App\Http\Requests\SearchPostRequest;
use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private SearchService $searchService;

    /**
     * @param SearchService $searchService
     */
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function searchPost(SearchPostRequest $searchPostRequest)
    {
        return $this->searchService->searchPost($searchPostRequest);
    }

    public function getSavedSearch(GetSavedSearchRequest $getSavedSearchRequest)
    {
        return $this->searchService->getSavedSearch($getSavedSearchRequest);
    }

    public function deleteSavedSearch(DeleteSavedSearchRequest $deleteSavedSearchRequest)
    {
        return $this->searchService->deleteSavedSearch($deleteSavedSearchRequest);
    }
}
