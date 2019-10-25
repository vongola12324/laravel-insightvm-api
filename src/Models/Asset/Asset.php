<?php


namespace Vongola\InsightVmApi\Models\Asset;

use Exception;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Base\Response;
use Vongola\InsightVmApi\Models\Base\Sendable;

class Asset extends Sendable
{
    protected $assetId = null;

    /**
     * Asset constructor.
     * Asset() will return all assets for which you have access.
     * Asset($id) will return the specified asset.
     * @param Client $client
     * @param int|null $assetId
     */
    public function __construct(Client $client, int $assetId = null)
    {
        parent::__construct($client);
        $this->client->pushNextPath('assets');
        if ($assetId !== null) {
            $this->assetId = $assetId;
            $this->client->pushNextPath($assetId);
        }
    }

    /**
     * Check If assetId null
     * @param bool $paramMustNull
     * @throws Exception
     */
    protected function checkParameter(bool $paramMustNull = false)
    {
        if ($paramMustNull ^ $this->assetId === null) {
            throw new Exception('Missing asset id.');
        }
    }

    /**
     * Returns all assets for which you have access that match the given search criteria.
     * @param int|null $page
     * @param int|null $size
     * @param string|null $sort
     * @param array $filters
     * @param string $match
     * @return Response
     * @throws Exception
     */
    public function search($page = null, $size = null, $sort = null, $filters = [], $match = "all")
    {
        $this->checkParameter(true);
        $this->client->setNextMethod('POST');
        $this->client->pushNextPath('search');
        $this->client->setNextQueryData([
            'page' => $page,
            'size' => $size,
            'sort' => $sort,
        ]);
        $this->client->setNextFormData([
            'filters' => $filters,
            'match' => $match,
        ]);
        return $this->get();
    }

    /**
     * Deletes the specified asset.
     * @return Response
     * @throws Exception
     */
    public function delete()
    {
        $this->checkParameter();
        $this->client->setNextMethod('DELETE');
        return $this->get();
    }

    /**
     * Returns the databases enumerated on an asset.
     * @throws Exception
     */
    public function databases()
    {
        $this->checkParameter();
        $this->client->pushNextPath('databases');
        return $this->get();
    }

    /**
     * @throws Exception
     */
    public function files()
    {
        $this->checkParameter();
        $this->client->pushNextPath('files');
        return $this->get();
    }

    /**
     * Returns the service running a port and protocol on the asset.
     * @param null $protocol
     * @param null $port
     * @return AssetService|Response
     * @throws Exception
     */
    public function services($protocol = null, $port = null)
    {
        $this->checkParameter();
        return new AssetService($this->getClient(), $protocol, $port);
    }

    /**
     * @throws Exception
     */
    public function software()
    {
        $this->checkParameter();
        $this->client->pushNextPath('software');
        return $this->get();
    }

    /**
     * Returns tags assigned to an asset.
     * @param null $tagId
     * @return AssetTag
     * @throws Exception
     */
    public function tags($tagId = null)
    {
        $this->checkParameter();
        return new AssetTag($this->getClient(), $tagId);
    }

    /**
     * Returns user groups enumerated on an asset.
     * @throws Exception
     */
    public function user_groups()
    {
        $this->checkParameter();
        $this->client->pushNextPath('user_groups');
        return $this->get();
    }

    /**
     * Returns users enumerated on an asset.
     * @throws Exception
     */
    public function users()
    {
        $this->checkParameter();
        $this->client->pushNextPath('users');
        return $this->get();
    }

    /**
     * operating_systems($page, $size, $sort) will return all operating systems discovered across all assets.
     * operating_systems($id) will return the details for an operating system.
     * @param null $idOrPage
     * @param array $vars
     * @return Response
     * @throws Exception
     */
    public function operating_systems($idOrPage = null, ...$vars)
    {
        $this->checkParameter();
        $this->client->pushNextPath('operating_systems');
        if (count($vars) === 0) {
            $this->client->pushNextPath($idOrPage);
        } elseif (count($vars) === 2) {
            $this->client->setNextQueryData([
                'page' => $idOrPage,
                'size' => $vars[0],
                'sort' => $vars[1],
            ]);
        }
        return $this->get();
    }

}