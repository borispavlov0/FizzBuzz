<?php

declare(strict_types=1);

namespace Boris\Fizzbuzz\Service;

use Boris\Fizzbuzz\Core\Service\Service;

class NumberGenerator implements Service
{
    /**
     * @param int $maxNumber
     * @return array
     */
    public function GenerateNumbersArray(int $maxNumber): array
    {
        $ret = [];
        for ($i = 1; $i <= $maxNumber; $i++) {
            if ($i%3 === 0 && $i%5 ===0) {
                $ret[] = "FizzBuzz";
                continue;
            }

            if ($i%3 === 0) {
                $ret[] = "Fizz";
                continue;
            }

            if ($i%5 === 0) {
                $ret[] = "Buzz";
                continue;
            }

            $ret[] = $i;
        }

        return $ret;
    }
}