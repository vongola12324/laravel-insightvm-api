<?php


namespace Vongola\InsightVmApi\Models\Asset;


use Exception;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Base\Response;
use Vongola\InsightVmApi\Models\Base\Sendable;

class AssetService extends Sendable
{
    protected $protocol = null;
    protected $port = null;

    /**
     * AssetService constructor.
     * Returns the service running a port and protocol on the asset.
     * @param $client
     * @param string|null $protocol
     * @param int|null $port
     */
    public function __construct(Client $client, string $protocol = null, int $port = null)
    {
        parent::__construct($client);
        $this->client->pushNextPath('services');
        if ($protocol !== null) {
            $this->protocol = $protocol;
            $this->client->pushNextPath($protocol);
        }
        if ($port !== null) {
            $this->port = $port;
            $this->client->pushNextPath($port);
        }
    }

    /**
     * Check If protocol or port null
     * @param bool $paramMustNull
     * @throws Exception
     */
    protected function checkParameter(bool $paramMustNull = false)
    {
        if ($paramMustNull ^ ($this->protocol === null || $this->port === null)) {
            throw new Exception('Missing asset service protocol or port.');
        }
    }

    /**
     * Returns the configuration (properties) of a port and protocol on an asset.
     * @return Response
     * @throws Exception
     */
    public function configurations()
    {
        $this->checkParameter();
        $this->client->pushNextPath('configurations');
        return $this->get();
    }

    /**
     * Returns the user groups enumerated on a port and protocol on an asset.
     * @return Response
     * @throws Exception
     */
    public function user_groups()
    {
        $this->checkParameter();
        $this->client->pushNextPath('user_groups');
        return $this->get();
    }

    /**
     * Returns the users enumerated on a port and protocol on an asset.
     * @return Response
     * @throws Exception
     */
    public function users()
    {
        $this->checkParameter();
        $this->client->pushNextPath('users');
        return $this->get();
    }

    /**
     * Returns the web applications running on a port and protocol on an asset.
     * @param int|null $webApplicationId
     * @return Response
     * @throws Exception
     */
    public function web_applications($webApplicationId = null)
    {
        $this->checkParameter();
        $this->client->pushNextPath('web_applications');
        if ($webApplicationId !== null) {
            $this->client->pushNextPath($webApplicationId);
        }
        return $this->get();
    }


}