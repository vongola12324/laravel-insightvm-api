<?php


namespace Vongola\InsightVmApi\Models\AssetGroup;


use Exception;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Base\Response;
use Vongola\InsightVmApi\Models\Base\Sendable;

class SearchCriteria extends Sendable
{
    /**
     * SearchCriteria constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->client->pushNextPath('search_criteria');
    }

    /**
     * Updates all the assets that belong to a static asset group.
     * @param array $filter
     * @param string|null $match
     * @return Response
     */
    public function update(array $filter = [], string $match = null)
    {
        $this->client->setNextMethod('PUT');
        $this->client->setNextFormData([
            'filters' => $filter,
            'match' => $match,
        ]);
        return $this->get();
    }

}