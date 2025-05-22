<?php

declare(strict_types=1);

namespace Daycode\Fictive\Exceptions;

use Exception;

class RateLimitExceeded extends Exception
{
    /**
     * Create a new method not available exception.
     */
    public function __construct()
    {
        parent::__construct('Rate limit exceeded: free-models-per-day. Add 4 credits to unlock 1000 free model requests per day');
    }
}
