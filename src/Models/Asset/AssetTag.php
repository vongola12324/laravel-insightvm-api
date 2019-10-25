<?php


namespace Vongola\InsightVmApi\Models\Asset;


use Exception;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Base\Response;
use Vongola\InsightVmApi\Models\Base\Sendable;

class AssetTag extends Sendable
{
    protected $tagId = null;

    /**
     * Group constructor.
     * Returns tags assigned to an asset.
     * @param Client $client
     * @param int|null $tagId
     */
    public function __construct(Client $client, int $tagId = null)
    {
        parent::__construct($client);
        $this->client->pushNextPath('tags');
        if ($tagId !== null) {
            $this->tagId = $tagId;
            $this->client->pushNextPath($tagId);
        }
    }

    /**
     * Check If tag id null
     * @param bool $paramMustNull
     * @throws Exception
     */
    protected function checkParameter(bool $paramMustNull = false)
    {
        if ($paramMustNull ^ $this->tagId === null) {
            throw new Exception('Missing asset tag id.');
        }
    }

    /**
     * Assigns the specified tag to the asset.
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
     * Removes the specified tag from the asset's tags.
     * @return Response
     * @throws Exception
     */
    public function delete()
    {
        $this->checkParameter();
        $this->client->setNextMethod('DELETE');
        return $this->get();
    }
}