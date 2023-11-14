<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetListBlocksRequest;
use App\Http\Requests\GetRequestedFriendsRequest;
use App\Http\Requests\SetAcceptFriendRequest;
use App\Http\Requests\SetBlockRequest;
use App\Http\Requests\SetRequestFriend;
use App\Services\PeopleRelationshipService;

class PeopleRelationshipController extends Controller
{
    private PeopleRelationshipService $peopleRelationshipService;

    /**
     * @param PeopleRelationshipService $peopleRelationshipService
     */
    public function __construct(PeopleRelationshipService $peopleRelationshipService)
    {
        $this->peopleRelationshipService = $peopleRelationshipService;
    }

    public function getRequestedFriends(GetRequestedFriendsRequest $getRequestedFriendsRequest)
    {
        return $this->peopleRelationshipService->getRequestedFriends($getRequestedFriendsRequest);
    }

    public function setAcceptFriend(SetAcceptFriendRequest $setAcceptedFriendRequest)
    {
        return $this->peopleRelationshipService->setAcceptFriend($setAcceptedFriendRequest);
    }

    public function setRequestFriend(SetRequestFriend $setRequestFriend)
    {
        return $this->peopleRelationshipService->setRequestFriend($setRequestFriend);
    }

    public function getListBlocks(GetListBlocksRequest $getListBlocksRequest)
    {
        return $this->peopleRelationshipService->getListBlocks($getListBlocksRequest);
    }

    public function setBlock(SetBlockRequest $setBlockRequest)
    {
        return $this->peopleRelationshipService->setBlock($setBlockRequest);
    }
}
