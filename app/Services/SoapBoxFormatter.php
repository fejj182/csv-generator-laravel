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
}