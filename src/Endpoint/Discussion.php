<?php

namespace Kiryi\Flaryi\Endpoint;

class Discussion extends Endpoint
{
    const APIENDPOINT = 'discussions';

    public function get(int $discussionId, ?array $responseFields = null): object
    {
        $this->setType('GET');
        $this->setUri($this->setEndpointId($discussionId));
        $this->setUri($this->setResponseFields($responseFields));
        $this->setUri();
        $this->setBody();

        try {
            return $this->call();
        } catch (\Exception $e) {
            throw new \Exception(sprintf($this::NOTFOUND, 'Discussion', 'ID', $discussionId));
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

    public function getByTitle(string $discussionTitle, ?array $responseFields = null, ?string $filter = null): object
    {
        if (
            $responseFields !== null
            && in_array('title', $responseFields) === false
        ) {
            $responseFields[] = 'title'; 
        }

        $discussions = $this->getAll($responseFields, $filter);

        foreach ($discussions->data as $discussion) {
            if ($discussion->attributes->title == $discussionTitle) {
                return $discussion;
            }
        }

        throw new \Exception(sprintf($this::NOTFOUND, 'Discussion', 'Title', $discussionTitle));
    }

    public function create(string $title, string $content, ?array $tagIds = null): object
    {
        $tagsJson = '';

        if ($tagIds !== null) {
            foreach ($tagIds as $tagId) {
                $tagsJson .= $this->createDataObjectJson('tags', $tagId);
                $tagsJson .= ',';
            }

            $tagsJson = substr($tagsJson, 0, -1); 
        }

        $this->setType('POST');
        $this->setUri();
        $this->setBody(sprintf(
            $this->getJsonBody(),
            $title,
            $content,
            $tagsJson
        ));

        return $this->call();
    }
}
