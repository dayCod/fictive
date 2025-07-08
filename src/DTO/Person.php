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
            PersonContext::setFieldSpecification($property, $arguments[0]);
        }

        return $this->attributes[$property] ?? null;
    }

    /**
     * Convert the model to its array form.
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
}
