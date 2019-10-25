<?php


namespace Vongola\InsightVmApi\Models\AssetDiscovery;


use Exception;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Base\Response;
use Vongola\InsightVmApi\Models\Base\Sendable;

class Connection extends Sendable
{
    protected $connectId = null;

    /**
     * Asset AssetDiscovery Connection constructor.
     * Connection() will return all discovery connections.
     * Connection($id) will return a discovery connection.
     * @param Client $client
     * @param int|null $connectId
     */
    public function __construct(Client $client, int $connectId = null)
    {
        parent::__construct($client);
        $this->client->pushNextPath('discovery_connections');
        if ($connectId !== null) {
            $this->connectId = $connectId;
            $this->client->pushNextPath($connectId);
        }
    }

    /**
     * Check If connectId null
     * @param bool $paramMustNull
     * @throws Exception
     */
    protected function checkParameter(bool $paramMustNull = false)
    {
        if ($paramMustNull ^ ($this->connectId === null)) {
            throw new Exception('Missing connect id.');
        }
    }

    /**
     * Attempts to reconnect the discovery connection.
     * @return Response
     * @throws Exception
     */
    public function connect()
    {
        $this->checkParameter();
        $this->client->setNextMethod('POST');
        $this->client->pushNextPath('connect');
        return $this->get();
    }
}