<?php

namespace App\Services;

use App\Enum\RequestStatusEnum;
use App\Enum\ResponseCodeEnum;
use App\Enum\StatusUserEnum;
use App\Enum\TypeRequestEnum;
use App\Http\Requests\GetListBlocksRequest;
use App\Http\Requests\GetRequestedFriendsRequest;
use App\Http\Requests\SetAcceptFriendRequest;
use App\Http\Requests\SetBlockRequest;
use App\Http\Requests\SetRequestFriend;
use App\Models\BlockList;
use App\Models\FriendList;
use App\Models\RequestFriend;
use App\Models\User;
use App\Response\Model\ResponseObject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeopleRelationshipService extends BaseService
{
    public function getRequestedFriends(GetRequestedFriendsRequest $getRequestedFriendsRequest)
    {
        $requestedFriends = RequestFriend::where('user_id', Auth::user()->id)
            ->where('request_type', TypeRequestEnum::USER_RECEIVE)
            ->offset($getRequestedFriendsRequest->index)
            ->limit($getRequestedFriendsRequest->count)
            ->get()
            ->each(function ($item, $key) {
                $item->detailUser;
            });

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $requestedFriends->toArray());

        return $this->responseData($response);
    }

    public function setAcceptFriend(SetAcceptFriendRequest $setAcceptedFriendRequest)
    {
        try {
            if (Auth::user()->id == $setAcceptedFriendRequest->user_id) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_1010);
                return $this->responseData($responseError);
            }

            DB::beginTransaction();

            $foundRequestedFriend = RequestFriend::where('user_id', Auth::user()->id)
                ->where('target_id', $setAcceptedFriendRequest->user_id)
                ->where('request_status', RequestStatusEnum::USER_PENDING)
                ->where('request_type', TypeRequestEnum::USER_RECEIVE)
                ->first();

            if (!$foundRequestedFriend) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9994);
                return $this->responseData($responseError);
            }

            $foundRequestedFriend->request_status = $setAcceptedFriendRequest->is_accept
                ? RequestStatusEnum::USER_APPROVE : RequestStatusEnum::USER_DENY;

            $foundRequestedFriend->save();

            if ($setAcceptedFriendRequest->is_accept) {
                FriendList::insert(array(
                    array(
                        'user_id' => Auth::user()->id,
                        'friend_id' => $setAcceptedFriendRequest->user_id,
                        'created_at' => Carbon::now()
                    ),
                    array(
                        'user_id' => $setAcceptedFriendRequest->user_id,
                        'friend_id' => Auth::user()->id,
                        'created_at' => Carbon::now()
                    ),
                ));
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

    public function setRequestFriend(SetRequestFriend $setRequestFriend)
    {
        try {
            if (Auth::user()->id == $setRequestFriend->user_id) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_1010);
                return $this->responseData($responseError);
            }

            $foundUser = User::where('id', $setRequestFriend->user_id)
                ->where('status_user', StatusUserEnum::ACTIVE)
                ->first();

            if (!$foundUser) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9995);
                return $this->responseData($responseError);
            }

            $blockUserList = $foundUser->listUserBlocked->pluck('user_blocked_id');

            if ($blockUserList->contains(Auth::user()->id)) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_1009);
                return $this->responseData($responseError);
            }

            $requestFriend = new RequestFriend();

            $requestFriend->user_id = Auth::user()->id;
            $requestFriend->target_id = $setRequestFriend->user_id;
            $requestFriend->request_type = TypeRequestEnum::USER_SEND;

            $requestFriend->save();

            DB::commit();

            $countRequestFriend = Auth::user()->sendRequestFriend->count();

            $data = [
                'requested_friends' => $countRequestFriend
            ];

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);

            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function getListBlocks(GetListBlocksRequest $getListBlocksRequest)
    {
        $blockList = BlockList::where('user_id', Auth::user()->id)->offset($getListBlocksRequest->index)
            ->limit($getListBlocksRequest->count)
            ->get()
            ->each(function ($block, $key) {
                $detailUser = $block->detailUser;
                $block['name'] = $detailUser->name;
                $block['avatar'] = $detailUser->avatar;
            })->makeHidden(['user_id', 'user_blocked_id']);

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $blockList->toArray());

        return $this->responseData($response);
    }

    public function setBlock(SetBlockRequest $setBlockRequest)
    {
        try {
            DB::beginTransaction();

            if (Auth::user()->id == $setBlockRequest->user_id) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
                return $this->responseData($responseError);
            }

            $foundUser = User::where('id', $setBlockRequest->user_id)->first();

            if (!$foundUser) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9995);
                return $this->responseData($responseError);
            }

            $foundBlock = BlockList::where('user_id', Auth::user()->id)
                ->where('user_blocked_id', $setBlockRequest->user_id)
                ->first();

            if (!$setBlockRequest->type) {
                if ($foundBlock) {
                    $responseError = new ResponseObject(ResponseCodeEnum::CODE_1010);
                    return $this->responseData($responseError);
                }

                $block = new BlockList();
                $block->user_id = Auth::user()->id;
                $block->user_blocked_id = $setBlockRequest->user_id;
                $block->created_at = Carbon::now();

                $block->save();
            } else {
                if (!$foundBlock) {
                    $responseError = new ResponseObject(ResponseCodeEnum::CODE_1010);
                    return $this->responseData($responseError);
                }

                $foundBlock->delete();
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
}
