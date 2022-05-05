<?php

namespace Boris\Fizzbuzz\Service;

use Boris\Fizzbuzz\Core\Service\Service;

class NumberPrinter implements Service
{
    /**
     * @param array $values
     * @return string
     */
    public function getRenderedString(array $values): string
    {
        return implode("\n", $values);
    }
}