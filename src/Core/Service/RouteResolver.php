<?php

declare(strict_types=1);

namespace Boris\Fizzbuzz\Core\Service;

use Boris\Fizzbuzz\Exception\IncorrectRouteDefinitionException;
use Boris\Fizzbuzz\Exception\MissingParameterValueException;
use Boris\Fizzbuzz\Exception\NoDefaultErrorRouteException;
use Boris\Fizzbuzz\Exception\RouteNotFoundException;

class RouteResolver implements Service
{
    /**
     * @var array
     */
    private $routes;

    /**
     * @param array $routes
     * @throws IncorrectRouteDefinitionException
     */
    public function __construct(array $routes)
    {
        $this->routes = $this->extractRoutes($routes);
    }

    /**
     * @param array $input
     * @return string
     * @throws MissingParameterValueException
     * @throws RouteNotFoundException
     */
    public function getRoute(array $input) : string
    {
        if (sizeof($input) > 1 || empty($input))
        {
            throw new MissingParameterValueException("Missing route value.");
        }

        $providedOption = array_keys($input)[0];


        if (!in_array($providedOption, array_keys($this->routes)))
        {
            throw new RouteNotFoundException("The route that you provided is not registered.");
        }

        return $this->routes[$providedOption]['class'];
    }

    /**
     * @return string
     * @throws NoDefaultErrorRouteException
     */
    public function getDefaultRoute() : string
    {
        foreach ($this->routes as $route)
        {
            if (array_key_exists("defaultErrorResponse", $route) && $route['defaultErrorResponse'])
            {
                return $route['class'];
            }
        }

        throw new NoDefaultErrorRouteException("No default error route has been defined.");
    }

    /**
     * @param string $route
     * @return bool
     */
    public function routeHasDefaultErrorHandling(string $route) : bool
    {
        foreach ($this->routes as $routeDefinition)
        {
            if (
                $routeDefinition['class'] == $route &&
                array_key_exists('overrideErrorResponse', $routeDefinition) &&
                $routeDefinition['overrideErrorResponse']
            )
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $route
     * @return string|null
     */
    public function getDefaultRouteParameterValue(string $route): ?string
    {
        foreach ($this->routes as $routeDefinition)
        {
            if (
                $routeDefinition['class'] == $route &&
                array_key_exists('defaultArgumentValue', $routeDefinition)
            ) {
                return $routeDefinition['defaultArgumentValue'];
            }
        }

        return null;
    }

    /**
     * @param array $routes
     * @return array
     * @throws IncorrectRouteDefinitionException
     */
    private function extractRoutes(array $routes) : array
    {
        $newRoutes = [];

        foreach ($routes as $key => $r)
        {
            $newRoutes[str_replace(":", "", $key)] = $r;

            if (!array_key_exists('class', $r))
            {
                throw new IncorrectRouteDefinitionException("Missing key 'class' for route definition ". $key);
            }
        }

        return $newRoutes;
    }
}