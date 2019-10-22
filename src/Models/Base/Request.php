<?php


namespace Vongola\InsightVmApi\Models\Base;


use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class Request
{
    protected $httpClient;
    protected $header;
    protected $action;

    /**
     * Request constructor.
     * @param Sendable $sendable
     */
    public function __construct($sendable)
    {
        $this->httpClient = new HttpClient();
        $this->action = $sendable;
        $ApiClient = $this->action->getClient();
        $this->prepareHeader($ApiClient->getAuthorization(), $ApiClient->getOtpAccessToken());
    }

    public function send()
    {
        try {
            $response = $this->httpClient->request(
                $this->action->getFullUrl(), $this->action['url'], $this->action['extra']
            );
        } catch (GuzzleException $e) {
            Log::error($e->getMessage(), $e->getTrace());
            $response = null;
        }
        return $response;
    }

    private function prepareHeader($authorization, $otpToken) {
        $header = [
            'Accept' => 'application/json',
            'Accept-Encoding' => 'deflate, gzip',
            'Accept-Language' => 'en-US',
            'Authorization' => $authorization,
        ];
        if ($otpToken !== null) {
            $header['Token'] = $otpToken;
        }
        $this->header = $header;
    }
}