<?php

namespace App\Contracts;

interface FormatterInterface
{
    public function arrayToCsv(array $array);
}