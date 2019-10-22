<?php


namespace Vongola\InsightVmApi\Models\Base;


use Exception;
use Illuminate\Support\Facades\Config;
use OTPHP\TOTP;
use Vongola\InsightVmApi\Models\Root;

class Client
{
    private static $instance = null;

    protected $url = null;
    protected $authorization = '';
    protected $token = null;
    protected $tokenGenerator = null;


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
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function root() {
        return new Root($this);
    }
}