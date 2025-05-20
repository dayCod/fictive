<?php

declare(strict_types=1);

namespace Daycode\Fictive\Services;

use Daycode\Fictive\Contracts\Location;
use Daycode\Fictive\FictiveProcessor;

class HandleLocation extends FictiveProcessor implements Location
{
    /**
     * Validate that the method call is valid and the prompt meets requirements.
     */
    public function validate(string $method, array $arguments): bool
    {
        return $method === 'latitude';
    }

    /**
     * Process the method call with given arguments and return the result.
     */
    public function process(string $method, array $arguments): mixed
    {
        $prompt = $arguments[0] ?? null;

        // Here you would implement AI integration logic to generate names
        // This is a placeholder that returns a dummy full name
        if (! empty($prompt)) {
            // Use the prompt to influence the name generation
            // This is where you would add your AI logic
            return 'Generated Latitude Based On: '.$prompt;
        }

        return '-77.0364'; // Default fallback
    }

    /**
     * Generate a latitude based on optional prompt.
     */
    public function latitude(?string $prompt = null): string
    {
        if ($this->validate('latitude', [$prompt])) {
            return $this->process('latitude', [$prompt]);
        }

        return 'Invalid';
    }
}
