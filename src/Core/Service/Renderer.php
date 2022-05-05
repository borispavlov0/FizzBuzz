<?php

declare(strict_types=1);

namespace Boris\Fizzbuzz\Core\Service;

use Boris\Fizzbuzz\ValueObject\Response;

class Renderer implements Service
{
    /**
     * @param Response $response
     */
    public function render(Response $response) : void
    {
        echo $response->getContent() . "\n";
    }
}