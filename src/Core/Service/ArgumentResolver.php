<?php

declare(strict_types=1);

namespace Boris\Fizzbuzz\Core\Service;

class ArgumentResolver implements Service
{
    /**
     * @param array $input
     * @return string|null
     */
    public function resolve(array $input) : ?string
    {
        if (empty($input))
        {
            return null;
        }

        $ret = array_values($input)[0];

        return is_bool($ret) ? null : $ret;
    }
}