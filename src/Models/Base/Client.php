<?php

namespace Vongola\InsightVmApi\Models\Base;

use Exception;
use Illuminate\Support\Facades\Config;
use OTPHP\TOTP;
use Vongola\InsightVmApi\Models\Asset\Asset;
use Vongola\InsightVmApi\Models\AssetDiscovery\Connection;
use Vongola\InsightVmApi\Models\AssetDiscovery\SonarQuery;
use Vongola\InsightVmApi\Models\Root;
use Vongola\InsightVmApi\Models\Software\Software;

class Client
{
    private static $instance = null;

    protected $url = null;
    protected $authorization = '';
    protected $token = null;
    protected $tokenGenerator = null;

    protected $method = "GET";
    protected $path = [];
    protected $data = [];

    /**
     * Client constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->url = Config::get('insightvm.url');
        $this->authorization = base64_encode(Config::get('insightvm.username') . ':' . Config::get('insightvm.password'));
        $this->token = Config::get('insightvm.token');

        if ($this->url === null or $this->authorization === '') {
            throw new Exception("Missing InsightVM Config!");
        }

        if ($this->token !== null) {
            $this->tokenGenerator = TOTP::create($this->token);
        }
        self::$instance = $this;
    }

    /**
     * Client clone
     * @throws Exception
     */
    public function __clone()
    {
        throw new Exception("You should not clone the client!");
    }

    public function getOtpAccessToken()
    {
        if ($this->token === null) {
            return null;
        }
        return $this->tokenGenerator->now();
    }

    public function getAuthorization()
    {
        return $this->authorization;
    }

    public function getBaseUrl()
    {
        return $this->url;
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function cleanNextAction()
    {
        $this->method = "GET";
        $this->path = [];
        $this->data = [];
    }

    public function getNextAction()
    {
        return [
            'method' => $this->method,
            'url' => $this->getBaseUrl() . implode('/', $this->path),
            'data' => $this->data,
        ];
    }

    public function setNextMethod(string $method)
    {
        $this->method = $method;
    }

    public function pushNextPath(string $path)
    {
        array_push($this->path, $path);
    }

    private function setNextData(array $data)
    {
        $this->data = array_merge_recursive($this->data, $data);
    }

    public function setNextQueryData(array $data)
    {
        $this->setNextData([
            'query' => $data,
        ]);
    }

    public function setNextFormData(array $data)
    {
        $this->setNextData([
            'form_params' => $data,
        ]);
    }

    public function setNextFileData(array $data)
    {
        $this->setNextData([
            'multipart' => $data,
        ]);
    }

    /**
     * @return Root
     */
    public function root()
    {
        return new Root($this);
    }

    /**
     * @param int|null $assetId
     * @return Asset
     */
    public function asset($assetId = null)
    {
        return new Asset($this, $assetId);
    }

    /**
     * @param int|null $idOrPage
     * @param array $vars
     * @return Software
     * @throws Exception
     */
    public function software($idOrPage = null, ...$vars)
    {
        return new Software($this, $idOrPage, ...$vars);
    }

    /**
     * @param int|null $connectId
     * @return Connection
     */
    public function discovery_connections($connectId = null)
    {
        return new Connection($this, $connectId);
    }

    /**
     * @param int|null $sonarId
     * @return SonarQuery
     */
    public function sonar_queries($sonarId = null)
    {
        return new SonarQuery($this, $sonarId);
    }
}
