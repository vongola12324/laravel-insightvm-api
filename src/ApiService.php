<?php


namespace Vongola\InsightVmApi;


use Vongola\InsightVmApi\Models\Base\Request;
use Vongola\InsightVmApi\Models\Base\Response;
use Vongola\InsightVmApi\Models\Base\Sendable;

class ApiService
{
    /**
     * @param Sendable $sendable
     * @return Request
     */
    public static function packRequest($sendable)
    {
        return new Request($sendable);
    }

    public static function packResponse($response)
    {
        return new Response($response);
    }

    /**
     * @param $sendable
     * @return Response
     */
    public static function send($sendable)
    {
        $request = self::packRequest($sendable);
        $response = $request->send();
        return self::packResponse($response);
    }
}