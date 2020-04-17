<?php

namespace Kiryi\Flaryi\Endpoint;

class User extends Endpoint
{
    const APIENDPOINT = 'users';

    public function get(int $userId, ?array $responseFields = null): object
    {
        $uri = '';
        $uri .= $this->setEndpointId($userId);
        $uri .= $this->setResponseFields($responseFields);
        
        $this->setType('GET');
        $this->setUri($uri);
        $this->setBody();

        return $this->call();
    }

    public function getAll(?array $responseFields = null): object
    {
        $this->setType('GET');
        $this->setUri($this->setResponseFields($responseFields));
        $this->setBody();

        return $this->call();
    }

    public function setGroups(int $userId, array $groupIds): object
    {
        $groupJson = '';

        foreach ($groupIds as $groupId) {
            $groupJson .= $this->createDataObjectJson('groups', $groupId);
            $groupJson .= ',';
        }

        $groupJson = substr($tagsJson, 0, -1);

        $this->setType('PATCH');
        $this->setUri($this->setEndpointId($userId));
        $this->setBody(sprintf($this->getJsonBody(), $groupJson));

        return $this->call();
    }
}
