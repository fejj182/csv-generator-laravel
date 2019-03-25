<?php

namespace App\Services;

use SoapBox\Formatter\Formatter as SoapBox;
use App\Contracts\FormatterInterface;

class SoapBoxFormatter implements FormatterInterface
{
    public function arrayToCsv(array $clients)
    {
        $clients = $this->capitalizeKeysForHeader($clients);
        $formatter = SoapBox::make($clients, SoapBox::ARR);
        return $formatter->toCsv();
    }

    private function capitalizeKeysForHeader(array $clients) {
        return array_map(function($client) {
            foreach($client as $key => $value) {
                $client[ucfirst($key)] = $value;
                unset($client[$key]);
            };
            return $client;
        }, $clients);
    }
}