<?php

declare(strict_types=1);

namespace Daycode\Fictive\Exceptions;

use Exception;

class MismatchPromptInput extends Exception
{
    /**
     * Create a new method not available exception.
     */
    public function __construct(string $prompt, string $method)
    {
        parent::__construct("Prompt [{$prompt}] is not valid and does not relates with method [{$method}].");
    }
}
