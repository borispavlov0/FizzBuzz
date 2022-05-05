<?php

namespace Boris\Fizzbuzz\ValueObject;

class Request
{
    /**
     * @var string
     */
    public $argument;

    /**
     * @param string|null $argument
     */
    public function __construct(string $argument = null)
    {
        $this->argument = $argument;
    }
}