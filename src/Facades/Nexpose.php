<?php

namespace Vongola\InsightVmApi\Facades;

use Illuminate\Support\Facades\Facade;
use Vongola\InsightVmApi\Models\Base\Client;

class Nexpose extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Client::class;
    }
}