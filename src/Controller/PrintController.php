<?php

declare(strict_types=1);

namespace Boris\Fizzbuzz\Controller;

use Boris\Fizzbuzz\Exception\MissingParameterValueException;
use Boris\Fizzbuzz\Exception\ServiceNotFoundException;
use Boris\Fizzbuzz\Service\NumberGenerator;
use Boris\Fizzbuzz\Service\NumberPrinter;
use Boris\Fizzbuzz\ValueObject\Request;
use Boris\Fizzbuzz\ValueObject\Response;

class PrintController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     * @throws ServiceNotFoundException|MissingParameterValueException
     */
    public function getResponse(Request $request) : Response
    {
        if (!is_numeric($request->argument)) {
            throw new MissingParameterValueException("The parameter value provided must be a number");
        }

        $maxNumber = intval($request->argument);
        /**
         * @var NumberGenerator $numberGenerator
         */
        $numberGenerator = $this->container->get('number-generator');
        $numbers = $numberGenerator->GenerateNumbersArray($maxNumber);

        /**
         * @var NumberPrinter $numberPrinter
         */
        $numberPrinter = $this->container->get('number-printer');

        return new Response($numberPrinter->getRenderedString($numbers));
    }

    /**
     * @param string $errorMessage
     * @return Response
     */
    public function onError(string $errorMessage): Response
    {
        return new Response($errorMessage);
    }
}