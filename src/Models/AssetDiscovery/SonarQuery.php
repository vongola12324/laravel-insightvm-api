<?php

namespace Vongola\InsightVmApi\Models\AssetDiscovery;

use Exception;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Base\Response;
use Vongola\InsightVmApi\Models\Base\Sendable;

class SonarQuery extends Sendable
{
    protected $sonarId = null;

    /**
     * Asset AssetDiscovery Sonar Query constructor.
     * SonarQuery() will return all sonar queries.
     * SonarQuery($id) will return a discovery connection.
     * @param Client $client
     * @param int|null $sonarId
     */
    public function __construct(Client $client, int $sonarId = null)
    {
        parent::__construct($client);
        $this->client->pushNextPath('sonar_queries');
        if ($sonarId !== null) {
            $this->sonarId = $sonarId;
            $this->client->pushNextPath($sonarId);
        }
    }

    /**
     * Check If sonarId null
     * @param bool $paramMustNull
     * @throws Exception
     */
    protected function checkParameter(bool $paramMustNull = false)
    {
        if ($paramMustNull ^ $this->sonarId === null) {
            throw new Exception('Parameter "sonarId" Mis-match.');
        }
    }

    /**
     * Creates a sonar query.
     * @param array $criteria
     * @param array $links
     * @param string $name
     * @return Response
     * @throws Exception
     */
    public function create(array $criteria, array $links, string $name)
    {
        $this->checkParameter(true);
        $this->client->setNextMethod('POST');
        $this->client->setNextFormData([
            'criteria' => $criteria,
            'links' => $links,
            'name' => $name,
        ]);
        return $this->get();
    }

    /**
     * Executes a Sonar query to discover assets with the given search criteria.
     * @param array $filters
     * @return Response
     * @throws Exception
     */
    public function search(array $filters)
    {
        $this->checkParameter(true);
        $this->client->setNextMethod('POST');
        $this->client->pushNextPath('search');
        $this->client->setNextFormData($filters);
        return $this->get();
    }

    /**
     * Updates a sonar query.
     * @param array $criteria
     * @param array $links
     * @param string $name
     * @return Response
     * @throws Exception
     */
    public function update(array $criteria, array $links, string $name)
    {
        $this->checkParameter();
        $this->client->setNextMethod('PUT');
        $this->client->setNextFormData([
            'criteria' => $criteria,
            'links' => $links,
            'name' => $name,
        ]);
        return $this->get();
    }

    /**
     * Removes a sonar query.
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
     * Returns the assets that are discovered by a Sonar query.
     * @return Response
     * @throws Exception
     */
    public function assets()
    {
        $this->checkParameter();
        $this->client->pushNextPath('asset');
        return $this->get();
    }
}
