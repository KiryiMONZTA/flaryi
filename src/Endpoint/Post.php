<?php

namespace Kiryi\Flaryi\Endpoint;

class Post extends Endpoint
{
    const APIENDPOINT = 'posts';

    public function get(int $postId, ?array $responseFields = null): object
    {
        $this->setType('GET');
        $this->setUri($this->setEndpointId($postId));
        $this->setUri($this->setResponseFields($responseFields));
        $this->setBody();

        try {
            return $this->call();
        } catch (\Exception $e) {
            throw new \Exception(sprintf($this::NOTFOUND, 'Post', 'ID', $postId));
        }
    }

    public function getAll(?array $responseFields = null, ?string $filter = null): object
    {
        $this->setType('GET');
        $this->setUri($this->setResponseFields($responseFields));
        $this->setUri($this->setFilter($filter));
        $this->setBody();

        return $this->call();
    }

    public function create(string $userId, string $discussionId, string $content): object
    {
        $this->setType('POST');
        $this->setUri();
        $this->setBody(sprintf(
            $this->getJsonBody(),
            $content,
            $userId,
            $discussionId
        ));
        
        return $this->call();
    }
}
