<?php

namespace App\Services;

use App\Traits\MakesHttpRequests;
use GuzzleHttp\ClientInterface;

class ClientRenewals
{
    use MakesHttpRequests;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getClients()
    {
        $content = $this->get('https://jsonplaceholder.typicode.com/users');

        return array_map(function($client) {
            return [
             'name' => $client->name ?? null,
             'email' => $client->email ?? null,
             'phone' => $client->phone ?? null,
             'company' => $client->company->name ?? null
            ];
        }, $content);
    }
}