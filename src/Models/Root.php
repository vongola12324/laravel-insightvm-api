<?php


namespace Vongola\InsightVmApi\Models;

use Vongola\InsightVmApi\ApiService;
use Vongola\InsightVmApi\Models\Base\Sendable;

class Root extends Sendable
{
    public function __construct($client)
    {
        parent::__construct($client);
    }
}