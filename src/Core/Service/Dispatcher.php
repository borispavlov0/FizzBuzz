<?php

declare(strict_types=1);

namespace Boris\Fizzbuzz\Core\Service;

use Boris\Fizzbuzz\Controller\BaseController;
use Boris\Fizzbuzz\Core\Container;
use Boris\Fizzbuzz\Exception\BaseException;
use Boris\Fizzbuzz\ValueObject\Request;
use Boris\Fizzbuzz\ValueObject\Response;
use RuntimeException;

class Dispatcher implements Service
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $controllerName
     * @param string|null $argument
     * @param bool $hasErrorHandling
     * @return Response
     */
    public function dispatch(string $controllerName, string $argument = null, bool $hasErrorHandling = false) : Response
    {
        $request = new Request($argument);

        /**
         * @var $controller BaseController
         */
        $controller = new $controllerName($this->container);

        try {
            $response = $controller->getResponse($request);
        } catch (BaseException $exception) {
            if ($hasErrorHandling)
            {
                $response = $controller->onError($exception->getMessage());
            } else
            {
                throw $exception;
            }
        }

        return $response;
    }

    /**
     * @param string $route
     * @param string $argument
     * @return Response
     */
    public function dispatchControllerError(string $route, string $argument) : Response
    {
        $controllerName = $route . "Controller";

        /**
         * @var $controller BaseController
         */
        $controller = new $controllerName($this->container);

        return $controller->onError($argument);
    }
}