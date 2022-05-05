<?php

declare(strict_types=1);

use Boris\Fizzbuzz\Controller\HelpController;
use Boris\Fizzbuzz\Controller\PrintController;
use Boris\Fizzbuzz\Core\Service\ArgumentResolver;
use Boris\Fizzbuzz\Core\Service\Dispatcher;
use Boris\Fizzbuzz\Core\Service\Renderer;
use Boris\Fizzbuzz\Core\Service\RouteResolver;
use Boris\Fizzbuzz\Service\NumberGenerator;
use Boris\Fizzbuzz\Service\NumberPrinter;

/**
 * for the routes that require/can use parameters, use ":" after the route definition
 * This is the notation used for php getopt() function. You can read more here:
 * https://www.php.net/manual/en/function.getopt.php
 */
$routes = [
    'h' => [
        'class' => HelpController::class,
        'defaultErrorResponse' => true, //this means that this route is called on any error by default
    ],
    'p::' => [
        'class' => PrintController::class,
        'overrideErrorResponse' => true, //this means that the controller has its own error response handler
        'defaultArgumentValue' => "100",
    ],
];

$services = [

    /**
     * FRAMEWORK SPECIFIC SERVICES
     */

    'route-resolver' => [
        'class' => RouteResolver::class,
        'arguments' => [
            $routes,
        ],
    ],
    'argument-resolver' => [
        'class' => ArgumentResolver::class,
    ],
    'dispatcher' => [
        'class' => Dispatcher::class,
        'arguments' => [
            'container',
        ],
    ],
    'renderer' => [
        'class' => Renderer::class,
    ],


    /**
     * CUSTOM SERVICES
     */
    'number-generator' => [
        'class' => NumberGenerator::class,
    ],
    'number-printer' => [
        'class' => NumberPrinter::class,
    ],
];
