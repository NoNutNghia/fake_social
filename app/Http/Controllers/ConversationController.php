<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteConversationRequest;
use App\Http\Requests\DeleteMessageRequest;
use App\Http\Requests\GetConversationRequest;
use App\Http\Requests\GetListConversationRequest;
use App\Http\Requests\SetReadMessageRequest;
use App\Services\ConversationService;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    private ConversationService $conversationService;

    /**
     * @param ConversationService $conversationService
     */
    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    public function getListConversation(GetListConversationRequest $getListConversationRequest)
    {
        return $this->conversationService->getListConversation($getListConversationRequest);
    }

    public function getConversation(GetConversationRequest $getConversationRequest)
    {
        return $this->conversationService->getConversation($getConversationRequest);
    }

    public function setReadMessage(SetReadMessageRequest $setReadMessageRequest)
    {
        return $this->conversationService->setReadMessage($setReadMessageRequest);
    }

    public function deleteConversation(DeleteConversationRequest $deleteConversationRequest)
    {
        return $this->conversationService->deleteConversation($deleteConversationRequest);
    }

    public function deleteMessage(DeleteMessageRequest $deleteMessageRequest)
    {
        return $this->conversationService->deleteMessage($deleteMessageRequest);
    }
}
