<?php

namespace Tests\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

trait MockHttpRequests
{
    protected function mock_client() {
        $this->mockHandler = new MockHandler();
        $handler = HandlerStack::create($this->mockHandler);
        $this->app->instance(ClientInterface::class, new Client(['handler' => $handler]));
    }

    protected function append_response($status = 200, array $headers = [], $body = null) {
        if (!is_null($body) && !is_string($body)) {
            $body = json_encode($body);
        }
        $this->mockHandler->append(new Response($status, $headers, $body));
    }
}