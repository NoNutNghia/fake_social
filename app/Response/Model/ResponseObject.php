<?php

namespace App\Response\Model;

class ResponseObject
{
    private string $code;
    private array $data;

    /**
     * @param string $code
     * @param array $data
     */
    public function __construct(
        string $code,
        array $data = []
    )
    {
        $this->code = $code;
        $this->data = $data;
    }

    public function toArray(): array
    {
        return array(
            "code" => $this->code,
            "message" => __('message_response')[$this->code],
            "data" => $this->data,
        );
    }
}
