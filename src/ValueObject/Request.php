<?php

namespace Boris\Fizzbuzz\ValueObject;

class Request
{
    /**
     * @var string
     */
    private $argument;

    /**
     * @param string|null $argument
     */
    public function __construct(string $argument = null)
    {
        $this->argument = $argument;
    }

    /**
     * @return string
     */
    public function getArgument(): ?string
    {
        return $this->argument;
    }
}