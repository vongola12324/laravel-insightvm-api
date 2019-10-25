<?php


namespace Vongola\InsightVmApi\Models\AssetGroup;


use Exception;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Base\Response;
use Vongola\InsightVmApi\Models\Base\Sendable;

class Asset extends Sendable
{
    protected $assetId = null;

    /**
     * Group constructor.
     * Groups() will returns all asset groups.
     * Groups($id) will return the asset group.
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
            throw new Exception('Parameter "groupId" Mis-match.');
        }
    }

    /**
     * Updates all the assets that belong to a static asset group.
     * @param array $assertIds
     * @return Response
     * @throws Exception
     */
    public function update(array $assertIds = [])
    {
        $this->checkParameter(true);
        $this->client->setNextMethod('PUT');
        $this->client->setNextFormData($assertIds);
        return $this->get();
    }

    /**
     * Removes the assets from the given static asset group.
     * @return Response
     * @throws Exception
     */
    public function delete()
    {
        $this->checkParameter(true);
        $this->client->setNextMethod('DELETE');
        return $this->get();
    }

    /**
     * Adds an asset to a static asset group.
     * @return Response
     * @throws Exception
     */
    public function assign()
    {
        $this->checkParameter();
        $this->client->setNextMethod('PUT');
        return $this->get();
    }

    /**
     * Removes an asset from an asset group.
     * @return Response
     * @throws Exception
     */
    public function unassign()
    {
        $this->checkParameter();
        $this->client->setNextMethod('DELETE');
        return $this->get();
    }
}