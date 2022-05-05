<?php

namespace Boris\Fizzbuzz\Controller;

use Boris\Fizzbuzz\Core\Container;
use Boris\Fizzbuzz\Exception\ResponseNotImplementedException;
use Boris\Fizzbuzz\ValueObject\Request;
use Boris\Fizzbuzz\ValueObject\Response;

class BaseController
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ResponseNotImplementedException
     */
    public function getResponse(Request $request) : Response
    {
        throw new ResponseNotImplementedException("Function 'getResponse' must be implemented.");
    }

    /**
     * @param string $errorMessage
     * @return Response
     * @throws ResponseNotImplementedException
     */
    public function onError(string $errorMessage) : Response
    {
        throw new ResponseNotImplementedException("Function 'onError' called but not implemented.");
    }
}