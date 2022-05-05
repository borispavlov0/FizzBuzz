<?php

declare(strict_types=1);

namespace Boris\Fizzbuzz\Controller;

use Boris\Fizzbuzz\ValueObject\Request;
use Boris\Fizzbuzz\ValueObject\Response;

class HelpController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getResponse(Request $request) : Response
    {
        return new Response(
            "\n\nUsage: php index.php -[p|h]
            \n\t-h : This help page
            \n\t-p<int|null> : Print the FizzBuzz numbers (supply a number right after to override the default limit of 100, e.g. \"-p299\")
            
        \n"
        );
    }
}