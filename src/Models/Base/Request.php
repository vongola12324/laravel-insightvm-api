<?php


namespace Vongola\InsightVmApi\Models\Base;


use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class Request
{
    protected $httpClient;
    protected $header;
    protected $nextAction;

    /**
     * Request constructor.
     * @param Sendable $sendable
     */
    public function __construct($sendable)
    {
        $this->httpClient = new HttpClient();
        $apiClient = $sendable->getClient();
        $this->nextAction = $apiClient->getNextAction();
        $this->prepareHeader($apiClient->getAuthorization(), $apiClient->getOtpAccessToken());
    }

    public function send()
    {
        try {
            $response = $this->httpClient->request(
                $this->nextAction['method'], $this->nextAction['url'], $this->nextAction['data']
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