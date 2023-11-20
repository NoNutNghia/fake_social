<?php

namespace App\Services;

use App\Enum\ResponseCodeEnum;
use App\Enum\StatusUserEnum;
use App\Http\Requests\DeleteConversationRequest;
use App\Http\Requests\DeleteMessageRequest;
use App\Http\Requests\GetConversationRequest;
use App\Http\Requests\GetListConversationRequest;
use App\Http\Requests\SetReadMessageRequest;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Response\Model\ResponseObject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConversationService extends BaseService
{
    public function getListConversation(GetListConversationRequest $getListConversationRequest)
    {
        if (isset($getListConversationRequest->index) && isset($getListConversationRequest->count)) {
            $listConversation = Conversation::where(function ($query) {
                $query->where('user_id', Auth::user()->id)
                    ->orWhere('partner_id', Auth::user()->id);
            })->limit($getListConversationRequest->index)->offset($getListConversationRequest->count)->get();
        } else {
            $listConversation = Conversation::where(function ($query) {
                $query->where('user_id', Auth::user()->id)
                    ->orWhere('partner_id', Auth::user()->id);
            })->get();
        }

        $countNotRead = 0;

        foreach ($listConversation as $conversation) {
            $listMessages = $conversation->list_messages;
            $countNotRead += $listMessages->filter(function ($item) {
                return $item->un_read;
            })->count();
            $conversation['lastMessage'] = $listMessages->last();
        }

        $data = [
            'listConversation' => $listConversation,
            'numNewMessage' => $countNotRead,
        ];

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);

        return $this->responseData($response);
    }

    public function getConversation(GetConversationRequest $getConversationRequest)
    {
        $foundConversation = Conversation::where(function ($query) use ($getConversationRequest){
            $query->where('partner_id', $getConversationRequest->partner_id)
                ->orWhere('user_id', $getConversationRequest->partner_id);
        })->where('id', $getConversationRequest->conversation_id)
            ->first();

        if (!$foundConversation) {
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9994);
            return $this->responseData($responseError);
        }

        if (isset($getConversationRequest->index) && isset($getConversationRequest->count)) {
            $listMessage = Message::where('conversation_id', $getConversationRequest->conversation_id)
                ->offset($getConversationRequest->index)
                ->limit($getConversationRequest->count)
                ->get();
        } else {
            $listMessage = $foundConversation->list_messages;
        }

        foreach ($listMessage as $message) {
            $message->sender;
        }

        $partner = User::where('id', $getConversationRequest->partner_id)->first();

        $data = [
            'list_messages' => $listMessage,
            'is_blocked' => 0
        ];

        if ($partner->list_user_blocked->pluck('user_blocked_id')->contains(Auth::user()->id)) {
            $data['is_blocked'] = 1;
        }

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);

        return $this->responseData($response);
    }

    public function setReadMessage(SetReadMessageRequest $setReadMessageRequest)
    {
        try {

            $foundUser = User::where('id', $setReadMessageRequest->partner_id)
                ->where('status_user', '!=' ,StatusUserEnum::DISABLE)
                ->first();

            if (!$foundUser) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9995);
                return $this->responseData($responseError);
            }

            $currentUser = Auth::user();

            if ($currentUser->list_user_blocked->pluck('user_blocked_id')->contains($setReadMessageRequest->partner_id)) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9994);
                return $this->responseData($responseError);
            }

            DB::beginTransaction();

            Message::where('conversation_id', $setReadMessageRequest->conversation_id)
                ->where('un_read', 1)
                ->update(['un_read' => 0]);

            DB::commit();

            $data = [
                'is_blocked' => $foundUser->list_user_blocked->pluck('user_blocked_id')->contains(Auth::user()->id)
            ];

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);

            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function deleteConversation(DeleteConversationRequest $deleteConversationRequest)
    {
        try {
            DB::beginTransaction();

            $foundConversation = Conversation::where('id', $deleteConversationRequest->conversation_id)
                ->first();

            if (!$foundConversation) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9994);
                return $this->responseData($responseError);
            }

            $foundConversation->delete();

            DB::commit();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000);

            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function deleteMessage(DeleteMessageRequest $deleteMessageRequest)
    {
        try {

            $foundUser = User::where('id', $deleteMessageRequest->partner_id)
                ->where('status_user', '!=' ,StatusUserEnum::DISABLE)
                ->first();

            if (!$foundUser) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9995);
                return $this->responseData($responseError);
            }

            DB::beginTransaction();

            $foundMessage = Message::where('id', $deleteMessageRequest->message_id)
                ->where('conversation_id', $deleteMessageRequest->conversation_id)
                ->first();

            if (!$foundMessage) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9994);
                return $this->responseData($responseError);
            }

            $foundMessage->delete();

            DB::commit();

            $data = [
                'is_blocked' => $foundUser->list_user_blocked->pluck('user_blocked_id')->contains(Auth::user()->id)
            ];

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);

            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }
}
