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

    public function setGroup(int $userId, int $groupId): object
    {
        $this->setType('PATCH');
        $this->setUri($this->setEndpointId($userId));
        $this->setBody(sprintf($this->getJsonBody(), $groupId));

        return $this->call();
    }
}
