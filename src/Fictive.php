<?php

declare(strict_types=1);

namespace Daycode\Fictive;

use Daycode\Fictive\Exceptions\MethodNotAvailableException;
use Daycode\Fictive\Services\HandlePerson;
use ReflectionClass;
use ReflectionMethod;

class Fictive
{
    /**
     * Map of method handlers.
     */
    protected array $handlers = [

        /**
         * Methods for HandlePerson
         */
        'fullName' => HandlePerson::class,
        'phoneNumber' => HandlePerson::class,

    ];

    /**
     * Cache of available methods.
     */
    protected array $availableMethods = [];

    /**
     * Constructor to initialize the available methods.
     */
    public function __construct()
    {
        $this->availableMethods = $this->getAllAvailableMethods();
    }

    /**
     * Magic method to dynamically handle calls to various methods.
     */
    public function __call(string $method, array $arguments)
    {
        if (! $this->isMethodAvailable($method)) {
            throw new MethodNotAvailableException($method);
        }

        $handlerClass = $this->getHandlerForMethod($method);
        if ($handlerClass === null || $handlerClass === '' || $handlerClass === '0') {
            throw new MethodNotAvailableException($method);
        }

        $handler = new $handlerClass;

        return $handler->$method(...$arguments);
    }

    /**
     * Get the handler class for a specific method.
     */
    protected function getHandlerForMethod(string $method): ?string
    {
        return $this->handlers[$method] ?? null;
    }

    /**
     * Determine if a method is available.
     */
    protected function isMethodAvailable(string $method): bool
    {
        return in_array($method, $this->availableMethods);
    }

    /**
     * Get all available methods from the contract interfaces.
     */
    protected function getAllAvailableMethods(): array
    {
        $methods = [];

        $interfaceClasses = $this->getContractInterfaces();

        foreach ($interfaceClasses as $interfaceClass) {
            $reflection = new ReflectionClass($interfaceClass);
            foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                $methods[] = $method->getName();
            }
        }

        return array_unique($methods);
    }

    /**
     * Get all contract interface classes.
     */
    protected function getContractInterfaces(): array
    {
        return [
            \Daycode\Fictive\Contracts\Person::class,
        ];
    }
}
