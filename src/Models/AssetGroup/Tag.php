<?php


namespace Vongola\InsightVmApi\Models\AssetGroup;


use Exception;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Base\Response;
use Vongola\InsightVmApi\Models\Base\Sendable;

class Tag extends Sendable
{
    protected $tagId = null;

    /**
     * Tag constructor.
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
     * Check If tagId null
     * @param bool $paramMustNull
     * @throws Exception
     */
    protected function checkParameter(bool $paramMustNull = false)
    {
        if ($paramMustNull ^ $this->tagId === null) {
            throw new Exception('Parameter "tagId" Mis-match.');
        }
    }

    /**
     * Updates the tags of an asset group.
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
     * Removes all tag associations from the asset group.
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
     * Adds a tag to an asset group.
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
     * Removes a tag from an asset group.
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