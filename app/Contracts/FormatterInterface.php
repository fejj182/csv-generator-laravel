<?php

namespace App\Contracts;

interface FormatterInterface
{
    public function arrayToCsv(array $array);

    public function xmlToArray(string $xml);
}