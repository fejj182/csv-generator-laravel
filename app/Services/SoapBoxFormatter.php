<?php

namespace App\Services;

use SoapBox\Formatter\Formatter as SoapBox;
use App\Contracts\FormatterInterface;

class SoapBoxFormatter implements FormatterInterface
{
    public function arrayToCsv(array $array)
    {
        return SoapBox::make($array, SoapBox::ARR)->toCsv();
    }

    public function xmlToArray(string $xml)
    {
        return SoapBox::make($xml, SoapBox::XML)->toArray();
    }
}