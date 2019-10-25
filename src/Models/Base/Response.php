<?php

namespace Vongola\InsightVmApi\Models\Base;

class Response
{
    protected $success = true;
    protected $statusCode;
    protected $result;

    public function __construct($response)
    {
        if (array_key_exists('status', $response) && $response['status'] !== 200) {
            $this->success = false;
            $this->statusCode = $response['status'];
            $this->result = [
                'link' => $response['link'],
                'message' => $response['message'],
            ];
        } else {
            $this->statusCode = 200;
            $this->result = $response;
        }
    }
}
