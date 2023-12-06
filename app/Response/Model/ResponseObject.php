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
            "data" => $this->toStringValue(),
        );
    }

    private function toStringValue(){
        if (count($this->data) === 0) return [];

        $data = json_encode($this->data);

        $arraySearchAndReplace = array(
            array('":', '":"'),
            array(',', '",'),
            array('""', '"'),
            array(']"', ']'),
            array('"[', '['),
            array('"{', '{'),
            array('}",', '},'),
            array('null}', 'null"}'),
            array('"null"', 'null'),
        );

        foreach ($arraySearchAndReplace as $element) {
            $data = str_replace($element[0], $element[1], $data);
        }
        $dataParse = json_decode($data);
        if (!$dataParse) {
            $data = substr_replace($data, '"', strlen($data) - 1 ,0);
            $dataParse = json_decode($data);
        }

        return $dataParse;
    }
}

