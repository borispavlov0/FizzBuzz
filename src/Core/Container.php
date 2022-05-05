<?php

declare(strict_types=1);

namespace Boris\Fizzbuzz\Core;

use Boris\Fizzbuzz\Core\Service\Service;
use Boris\Fizzbuzz\Exception\IncorrectServiceDefinitionException;
use Boris\Fizzbuzz\Exception\ServiceNotFoundException;

class Container
{
    /**
     * @var array
     */
    private $serviceMap = [];

    /**
     * @param array $serviceDefinitions
     * @throws IncorrectServiceDefinitionException|ServiceNotFoundException
     */
    public function __construct(array $serviceDefinitions)
    {
        foreach ($serviceDefinitions as $service => $definition)
        {
            if (!is_array($definition) || !array_key_exists('class', $definition))
            {
                throw new IncorrectServiceDefinitionException("The service " . $service . " has no class definition.");
            }

            $arguments = [];
            if (array_key_exists('arguments', $definition))
            {
                $arguments = $definition['arguments'];
            }
            if (in_array('container', $arguments))
            {
                $arguments[array_search('container', $arguments)] = $this;
            }

            foreach($arguments as $argument)
            {
                if (is_string($argument) && substr($argument, 0, 1) == "@")
                {
                    $arguments[array_search($argument, $arguments)] = $this->get(str_replace("@", "", $argument));
                }
            }

            $this->serviceMap[$service] = new $definition['class'](...$arguments);
        }

    }

    /**
     * @param string $name
     * @return Service
     * @throws ServiceNotFoundException
     */
    public function get(string $name) : Service
    {
        if (!array_key_exists($name, $this->serviceMap))
        {
            throw new ServiceNotFoundException("Undefined service " . $name);
        }

        return $this->serviceMap[$name];
    }

}