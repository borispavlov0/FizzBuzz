<?php

declare(strict_types=1);

use Boris\Fizzbuzz\Controller\PrintController;
use Boris\Fizzbuzz\Core\Container;
use Boris\Fizzbuzz\Exception\MissingParameterValueException;
use Boris\Fizzbuzz\Service\NumberGenerator;
use Boris\Fizzbuzz\Service\NumberPrinter;
use Boris\Fizzbuzz\ValueObject\Request;
use Boris\Fizzbuzz\ValueObject\Response;
use PHPUnit\Framework\TestCase;

class PrintControllerTest extends TestCase
{
    private $targetResponseArray =
        ['1','2','Fizz','4','Buzz','Fizz','7','8','Fizz','Buzz','11','Fizz','13','14','FizzBuzz'];

    public function testResponse()
    {
        $numberGeneratorMock = $this->createMock(NumberGenerator::class);
        $numberGeneratorMock->method('generateNumbersArray')
            ->with(15)
            ->willReturn($this->targetResponseArray);

        $numberPrintMock = $this->createMock(NumberPrinter::class);
        $numberPrintMock->method('getRenderedString')
            ->with($this->targetResponseArray)
            ->willReturn($this->responseArrayToString());

        $requestMock = $this->createMock(Request::class);
        $requestMock->method('getArgument')
            ->willReturn($this->getRequestArgument());

        $containerMock = $this->createMock(Container::class);
        $containerMock->method('get')
            ->withConsecutive(['number-generator'], ['number-printer'])
            ->willReturnOnConsecutiveCalls($numberGeneratorMock, $numberPrintMock);

        $controller = new PrintController($containerMock);

        $response = new Response($this->responseArrayToString());

        $this->assertEquals($response, $controller->getResponse($requestMock));
    }

    public function testStringAsParameter()
    {
        $containerMock = $this->createMock(Container::class);
        $controller = new PrintController($containerMock);
        $requestMock = $this->createMock(Request::class);
        $requestMock->method('getArgument')
            ->willReturn('abc');

        $this->expectException(MissingParameterValueException::class);
        $controller->getResponse($requestMock);
    }

    private function responseArrayToString(): string
    {
        return implode("\n", $this->targetResponseArray);
    }

    private function getRequestArgument(): string
    {
        return strval(sizeof($this->targetResponseArray));
    }
}