<?php

declare(strict_types=1);

namespace Daycode\Fictive\DTO;

use Daycode\Fictive\LLM\Context\PersonContext;
use Daycode\Fictive\LLM\OpenRouter;
use Illuminate\Support\Str;

class Person
{
    /**
     * Define the model's default state.
     */
    public function __construct(protected array $attributes) {}

    /**
     * Handle dynamic method calls to the model.
     */
    public function __call(string $method, array $arguments): mixed
    {
        $property = Str::snake($method);

        if ($arguments !== [] && is_string($arguments[0])) {
            return $this->generateSpecificField($property, $arguments[0]);
        }

        return $this->attributes[$property] ?? null;
    }

    /**
     * Generate specific field with custom specification
     */
    protected function generateSpecificField(string $field, string $specification): ?string
    {
        $contextPrompt = PersonContext::getSpecificFieldContext($field, $specification);

        try {
            $response = (new OpenRouter)
                ->setSystemPrompt($contextPrompt)
                ->setUserPrompt("Generate one {$field} value.")
                ->execute();

            if (isset($response?->error)) {
                return $this->attributes[$field] ?? null;
            }

            $content = trim($response->choices[0]->message->content);

            $content = trim($content, '"\'');

            return $content;
        } catch (\Exception) {
            return $this->attributes[$field] ?? null;
        }
    }

    /**
     * Convert the model to its array form.
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
}
