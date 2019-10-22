<?php


namespace Vongola\InsightVmApi\Models\Base;

use Vongola\InsightVmApi\ApiService;

class Sendable
{
    protected $client = null;

    protected $method = "GET";
    protected $path = [''];
    protected $data = [];

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
    public function getClient()
    {
        return $this->client;
    }

    public function get()
    {
        ApiService::send($this);
    }

    protected function pushUrlPath($path)
    {
        array_push($this->path, $path);
    }

    public function getFullUrl() {
        $base = $this->client->getBaseUrl();
        return $base . '/' . implode('/', $this->path);
    }

    protected function setMethod($method) {
        $this->method = $method;
    }

    public function getMethod() {
        return $this->method;
    }

    protected function setData($data) {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}