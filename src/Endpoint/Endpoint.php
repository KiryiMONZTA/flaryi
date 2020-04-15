<?php

namespace Kiryi\Flaryi\Endpoint;

use Kiryi\Flaryi\Client;

abstract class Endpoint
{
    const JSONFILEPATH = __DIR__ . '/../../asset/json/';
    const ENDPOINT = '';

    protected ?Client $client = null;
    protected string $type = '';
    protected string $uri = '';
    protected string $body = '';

    public function __construct (Client $client)
    {
        $this->client = $client;
    }

    protected function call(): object
    {
        return json_decode($this->client->sendRequest($this->type, $this->uri, $this->body));
    }

    protected function setType(string $type): void
    {
        $this->type = $type;
    }

    protected function setUri(string $uri = ''): void
    {
        $this->uri = $this::ENDPOINT . $uri;
    }

    protected function setBody(string $body = ''): void
    {
        $this->body = $body;
    }

    protected function getJsonBody(): string
    {
        $className = lcfirst((new \ReflectionClass($this))->getShortName());
        $functionName = ucfirst(debug_backtrace()[1]['function']);

        return file_get_contents(self::JSONFILEPATH . $className . $functionName . '.json');
    }

    protected function setEndpointId(int $id): string
    {
        $uriPart = '';

        if ($id !== null) {
            $uriPart .= '/' . $id;
        }

        return $uriPart;
    }

    protected function setResponseFields(?array $responseFields): string
    {
        $uriPart = '';

        if ($responseFields !== null) {
            $uriPart .= '?fields[users]=';

            foreach ($responseFields as $field) {
                $uriPart .= $field . ',';
            }
            
            $uriPart = substr($uriPart, 0, -1);
        }

        return $uriPart;
    }
}
