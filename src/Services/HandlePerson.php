<?php

declare(strict_types=1);

namespace Daycode\Fictive\Services;

use Daycode\Fictive\Contracts\Person;
use Daycode\Fictive\FictiveProcessor;

class HandlePerson extends FictiveProcessor implements Person
{
    /**
     * Validate that the method call is valid and the prompt meets requirements.
     */
    public function validate(string $method, array $arguments): bool
    {
        // Validate the method name
        // Add any specific validation logic for the fullName method
        // For now, we'll just return true
        return $method === 'fullName';
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
            return 'Generated Name Based On: '.$prompt;
        }

        return 'John Doe'; // Default fallback
    }

    /**
     * Generate a full name based on optional prompt.
     */
    public function fullName(?string $prompt = null): string
    {
        if ($this->validate('fullName', [$prompt])) {
            return $this->process('fullName', [$prompt]);
        }

        return 'Invalid';
    }
}
