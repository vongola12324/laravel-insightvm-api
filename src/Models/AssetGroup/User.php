<?php

namespace Vongola\InsightVmApi\Models\AssetGroup;

use Exception;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Base\Response;
use Vongola\InsightVmApi\Models\Base\Sendable;

class User extends Sendable
{
    protected $userId = null;

    /**
     * Tag constructor.
     * @param Client $client
     * @param int|null $userId
     */
    public function __construct(Client $client, int $userId = null)
    {
        parent::__construct($client);
        $this->client->pushNextPath('users');
        if ($userId !== null) {
            $this->userId = $userId;
            $this->client->pushNextPath($userId);
        }
    }

    /**
     * Check If userId null
     * @param bool $paramMustNull
     * @throws Exception
     */
    protected function checkParameter(bool $paramMustNull = false)
    {
        if ($paramMustNull ^ $this->userId === null) {
            throw new Exception('Parameter "userId" Mis-match.');
        }
    }

    /**
     * Grants users with sufficient privileges access to an asset group.
     * @param array $userIds
     * @return Response
     * @throws Exception
     */
    public function update(array $userIds = [])
    {
        $this->checkParameter(true);
        $this->client->setNextMethod('PUT');
        $this->client->setNextFormData($userIds);
        return $this->get();
    }

    /**
     * Grants a user with sufficient privileges access to the asset group.
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
     * Removes a user's access from an asset group.
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
