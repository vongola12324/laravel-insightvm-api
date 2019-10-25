<?php


namespace Vongola\InsightVmApi\Models\Software;


use Exception;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Base\Sendable;

class Software extends Sendable
{
    /**
     * Software constructor.
     * Software($page, $size, $sort) will return all software enumerated on any asset.
     * Software($id) will return the details for software.
     * @param Client $client
     * @param int|null $idOrPage
     * @param array $vars
     * @throws Exception
     */
    public function __construct(Client $client, int $idOrPage = null, ...$vars)
    {
        parent::__construct($client);
        $this->client->pushNextPath('software');
        if (count($vars) === 0) {
            if ($idOrPage !== null) {
                $this->client->pushNextPath($idOrPage);
            }
        } else if (count($vars) === 2) {
            $this->client->setNextQueryData([
                'page' => $idOrPage,
                'size' => $vars[0],
                'sort' => $vars[1],
            ]);
        } else {
            throw new Exception('Parameter mis-match');
        }
    }
}