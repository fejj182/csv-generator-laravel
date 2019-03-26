<?php

namespace App\Traits;

trait MakesHttpRequests
{
    protected function get($url)
    {
        $response = $this->client->request('GET', $url);
        return json_decode($response->getBody()->getContents());
    }
}