<?php

declare(strict_types=1);

namespace Daycode\Fictive\Services;

use Daycode\Fictive\Contracts\Person;
use Daycode\Fictive\Exceptions\MismatchPromptInput;
use Daycode\Fictive\Exceptions\RateLimitExceeded;
use Daycode\Fictive\FictiveProcessor;
use Daycode\Fictive\LLM\Context\PersonCtx;
use Daycode\Fictive\LLM\OpenRouter;
use Illuminate\Support\Facades\Cache;

class HandlePerson extends FictiveProcessor implements Person
{
    /**
     * Validate that the method call is valid and the prompt meets requirements.
     */
    public function validate(string $method, array $arguments): bool
    {
        $method = strtolower($method);
        $prompt = $arguments[0] ?? null;

        $response = (new OpenRouter)
            ->setSystemPrompt(PersonCtx::validationContext($method, $prompt))
            ->setUserPrompt($prompt)
            ->execute();

        if (isset($response?->error) && $response?->error->code == 429) {
            throw new RateLimitExceeded;
        }

        return boolval($response->choices[0]->message->content);
    }

    /**
     * Process the method call with given arguments and return the result.
     */
    public function process(string $method, array $arguments): mixed
    {
        $prompt = $arguments[0] ?? null;

        $cache = Cache::remember(
            key: 'fictive-context',
            ttl: now()->addHour(),
            callback: fn (): array => []
        );

        $existingResponses = json_encode($cache[$method] ?? []);

        $response = (new OpenRouter)
            ->setSystemPrompt(PersonCtx::processContext($method, $prompt, $existingResponses))
            ->setUserPrompt($arguments[0])
            ->execute();

        if (isset($response?->error) && $response?->error->code == 429) {
            throw new RateLimitExceeded;
        }

        $newResponse = $response->choices[0]->message->content ?? 'N/A';
        $cache[$method][] = $newResponse;
        Cache::put('fictive-context', $cache);

        return $newResponse;
    }

    /**
     * Generate a full name based on optional prompt.
     */
    public function fullName(?string $prompt = null): string
    {
        if ($this->validate('fullName', [$prompt])) {
            return $this->process('fullName', [$prompt]);
        }

        throw new MismatchPromptInput($prompt, 'fullName');
    }

    /**
     * Generate a phone number based on optional prompt.
     */
    public function phoneNumber(?string $prompt = null): string
    {
        if ($this->validate('phoneNumber', [$prompt])) {
            return $this->process('phoneNumber', [$prompt]);
        }

        throw new MismatchPromptInput($prompt, 'phoneNumber');
    }

    /**
     * Generate a religion based on optional prompt.
     */
    public function religion(?string $prompt = null): string
    {
        if ($this->validate('religion', [$prompt])) {
            return $this->process('religion', [$prompt]);
        }

        throw new MismatchPromptInput($prompt, 'religion');
    }

    /**
     * Generate a hobby based on optional prompt.
     */
    public function hobby(?string $prompt = null): string
    {
        if ($this->validate('hobby', [$prompt])) {
            return $this->process('hobby', [$prompt]);
        }

        throw new MismatchPromptInput($prompt, 'hobby');
    }

    /**
     * Generate a blood group based on optional prompt.
     */
    public function bloodGroup(?string $prompt = null): string
    {
        if ($this->validate('bloodGroup', [$prompt])) {
            return $this->process('bloodGroup', [$prompt]);
        }

        throw new MismatchPromptInput($prompt, 'bloodGroup');
    }

    /**
     * Generate a job position based on optional prompt.
     */
    public function jobPosition(?string $prompt = null): string
    {
        if ($this->validate('jobPosition', [$prompt])) {
            return $this->process('jobPosition', [$prompt]);
        }

        throw new MismatchPromptInput($prompt, 'jobPosition');
    }

    /**
     * Generate a job desk based on optional prompt.
     */
    public function jobDesc(?string $prompt = null): string
    {
        if ($this->validate('jobDesk', [$prompt])) {
            return $this->process('jobDesk', [$prompt]);
        }

        throw new MismatchPromptInput($prompt, 'jobDesk');
    }
}
