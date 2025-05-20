<?php

declare(strict_types=1);

namespace Daycode\Fictive;

abstract class FictiveProcessor
{
    /**
     * Validate that the method call is valid and the prompt meets requirements.
     */
    abstract public function validate(string $method, array $arguments): bool;

    /**
     * Process the method call with given arguments and return the result.
     */
    abstract public function process(string $method, array $arguments): mixed;
}
