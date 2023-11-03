<?php

namespace App\DTO;

class PushNotificationDTO
{
    private $noti_request;
    private $noti_post_by_myself;
    private $noti_comment;
    private $noti_react_post;
    private $noti_react_comment;
    private $noti_post_by_friend;

    /**
     * @param $noti_request
     * @param $noti_post_by_myself
     * @param $noti_comment
     * @param $noti_react_post
     * @param $noti_react_comment
     * @param $noti_post_by_friend
     */
    public function __construct(
        $noti_request,
        $noti_post_by_myself,
        $noti_comment,
        $noti_react_post,
        $noti_react_comment,
        $noti_post_by_friend
    )
    {
        $this->noti_request = $noti_request;
        $this->noti_post_by_myself = $noti_post_by_myself;
        $this->noti_comment = $noti_comment;
        $this->noti_react_post = $noti_react_post;
        $this->noti_react_comment = $noti_react_comment;
        $this->noti_post_by_friend = $noti_post_by_friend;
    }


}
