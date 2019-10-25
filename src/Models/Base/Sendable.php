<?php

namespace Vongola\InsightVmApi\Models\Base;

use Vongola\InsightVmApi\ApiService;

class Sendable
{
    protected $client = null;

    /**
     * Sendable constructor.
     * @param Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return $this->client;
    }

    public function get()
    {
        $response = ApiService::send($this);
        $this->client->cleanNextAction();
        return $response;
    }

    protected function checkParameter()
    {
    }
}
