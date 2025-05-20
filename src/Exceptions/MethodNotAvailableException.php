<?php

declare(strict_types=1);

namespace Daycode\Fictive\Exceptions;

use Exception;

class MethodNotAvailableException extends Exception
{
    /**
     * Create a new method not available exception.
     */
    public function __construct(string $method)
    {
        parent::__construct("Method [{$method}] is not available in any of the implemented interfaces.");
    }
}
