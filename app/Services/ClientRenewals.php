<?php

namespace App\Services;

use App\Contracts\FormatterInterface;
use App\Traits\MakesHttpRequests;
use GuzzleHttp\ClientInterface;

class ClientRenewals
{
    use MakesHttpRequests;

    public function __construct(
        ClientInterface $client,
        FormatterInterface $formatter
    ){
        $this->client = $client;
        $this->formatter = $formatter;
    }

    public function getClientsFromJson()
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

    public function getClientsFromXml(string $path)
    {
        $xml = load_file($path . '.xml');
        $xmlArray = $this->formatter->xmlToArray($xml);
        $content = $xmlArray['item'];

        return array_map(function($client) {
            return [
             'name' => $client['name'] ?? null,
             'email' => $client['email'] ?? null,
             'phone' => $client['phone'] ?? null,
             'company' => $client['company']['name'] ?? null
            ];
        }, $content);
    }

    public function getCsvFromClients(array $clients)
    {
        $this->mapKeysToTitles($clients);
        return $this->formatter->arrayToCsv($clients);
    }

    private function mapKeysToTitles(array &$clients) {
        $clients = array_map(function($client) {
            return [
                'Nombre' => $client['name'],
                'Email' => $client['email'],
                'Teléfono' => $client['phone'],
                'Empresa' => $client['company']
            ];
        }, $clients);
    }
}