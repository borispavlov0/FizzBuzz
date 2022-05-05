<?php

namespace Boris\Fizzbuzz\ValueObject;

class Response
{
    /**
     * @var string
     */
    private $content;

    public function __construct(string $content = null)
    {
        if (!empty($content))
        {
            $this->content = $content;
        }
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}