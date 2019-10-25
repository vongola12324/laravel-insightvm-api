<?php

namespace Vongola\InsightVmApi\Models\AssetGroup;

use Exception;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Base\Response;
use Vongola\InsightVmApi\Models\Base\Sendable;

class Group extends Sendable
{
    protected $groupId = null;

    /**
     * Group constructor.
     * Groups() will returns all asset groups.
     * Groups($id) will return the asset group.
     * @param Client $client
     * @param int|null $groupId
     */
    public function __construct(Client $client, int $groupId = null)
    {
        parent::__construct($client);
        $this->client->pushNextPath('asset_groups');
        if ($groupId !== null) {
            $this->groupId = $groupId;
            $this->client->pushNextPath($groupId);
        }
    }

    /**
     * Check If groupId null
     * @param bool $paramMustNull
     * @throws Exception
     */
    protected function checkParameter(bool $paramMustNull = false)
    {
        if ($paramMustNull ^ $this->groupId === null) {
            throw new Exception('Parameter "groupId" Mis-match.');
        }
    }

    /**
     * Creates a new asset group.
     * @param string|null $name
     * @param string|null $type
     * @param string $desc
     * @param array|null $criteria
     * @param array|null $vuln
     * @return Response
     * @throws Exception
     */
    public function create(string $name, string $type, string $desc = null, array $criteria = null, array $vuln = null)
    {
        $this->checkParameter(true);
        $this->client->setNextMethod('POST');
        $this->client->setNextFormData([
            'name' => $name,
            'type' => $type,
            'description' => $desc,
            'searchCriteria' => $criteria,
            'vulnerabilities' => $vuln,
        ]);
        return $this->get();
    }

    /**
     * Updates the details of an asset group.
     * @param string $name
     * @param string $type
     * @param string|null $desc
     * @param array|null $criteria
     * @param array|null $vuln
     * @return Response
     * @throws Exception
     */
    public function update(string $name, string $type, string $desc = null, array $criteria = null, array $vuln = null)
    {
        $this->checkParameter();
        $this->client->setNextMethod('PUT');
        $this->client->setNextFormData([
            'name' => $name,
            'type' => $type,
            'description' => $desc,
            'searchCriteria' => $criteria,
            'vulnerabilities' => $vuln,
        ]);
        return $this->get();
    }

    /**
     * Deletes the asset group.
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
     * @param null $assetId
     * @return Asset
     * @throws Exception
     */
    public function asset($assetId = null)
    {
        $this->checkParameter();
        return new Asset($this->getClient(), $assetId);
    }

    /**
     * @return SearchCriteria
     * @throws Exception
     */
    public function searchCriteria()
    {
        $this->checkParameter();
        return new SearchCriteria($this->getClient());
    }
}
