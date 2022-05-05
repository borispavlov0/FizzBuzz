<?php

declare(strict_types=1);

use Boris\Fizzbuzz\Core\Container;
use Boris\Fizzbuzz\Exception\BaseException;
use Boris\Fizzbuzz\Exception\NoDefaultErrorRouteException;
use Boris\Fizzbuzz\Core\Service\ArgumentResolver;
use Boris\Fizzbuzz\Core\Service\Dispatcher;
use Boris\Fizzbuzz\Core\Service\Renderer;
use Boris\Fizzbuzz\Core\Service\RouteResolver;
use Boris\Fizzbuzz\ValueObject\Response;

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/config/config.php";
/** @var $services array */
/** @var $routes array */

//container containing all services
//manages dependency injections based on the config inside $services
$container = new Container($services);

/**
 * Service that finds a route based on the input
 *
 * @var RouteResolver $routeResolver
 */
$routeResolver = $container->get("route-resolver");

/**
 * Service that dispatches the call to the correct route class defined in $services
 *
 * @var Dispatcher $dispatcher
 */
$dispatcher = $container->get("dispatcher");


/**
 * Provides a wrapper to easily get the input argument
 *
 * @var ArgumentResolver $argumentResolver
 */
$argumentResolver = $container->get("argument-resolver");

/**
 * Renders responses from controllers
 *
 * @var Renderer $renderer
 */
$renderer = $container->get("renderer");


$allRoutes = implode("", array_keys($routes));
$input = getopt($allRoutes);
try
{
    //try to get the desired route
    $route = $routeResolver->getRoute($input);

} catch (BaseException $exception)
{
    $route = null;
}

//if the desired route does not exist or has failed
if (!$route)
{
    try {
        //get the default error response defined in $routes
        $route = $routeResolver->getDefaultRoute();
    } catch (NoDefaultErrorRouteException $exception)
    {
        //if there is no default response defined anywhere, print the exception
        $response = new Response();
        $response->setContent($exception->getMessage());
        $renderer->render($response);
        die;
    }
}


try {
    //try to dispatch the call
    //if the controller handles its own exception this will not throw an exception
    $response = $dispatcher->dispatch(
        $route,
        $argumentResolver->resolve($input) ?? $routeResolver->getDefaultRouteParameterValue($route),
        $routeResolver->routeHasDefaultErrorHandling($route)
    );

} catch (RuntimeException $exception)
{
    //if no controller error handling is defined, go to the default route for error display
    $response = $dispatcher->dispatch($routeResolver->getDefaultRoute());
}

//finally, render the response from the controller
$renderer->render($response);