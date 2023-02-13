<?php

namespace Rattananen\Webdriver;

use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    public function delete(string $uri): ResponseInterface;

    public function get(string $uri): ResponseInterface;

    public function post(string $uri, mixed $data = null): ResponseInterface;
}
