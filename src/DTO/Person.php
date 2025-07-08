<?php

declare(strict_types=1);

namespace Daycode\Fictive\DTO;

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
        $value = $this->attributes[$property] ?? null;

        if ($arguments === []) {
            return $value;
        }

        return $this->applyManipulations($value, $arguments);
    }

    /**
     * Apply manipulations to the field value based on arguments
     */
    protected function applyManipulations(mixed $value, array $arguments): mixed
    {
        if ($value === null) {
            return null;
        }

        foreach ($arguments as $manipulation) {
            if (is_callable($manipulation)) {
                $value = $manipulation($value);
            } elseif (is_string($manipulation)) {
                $value = $this->applyStringManipulation($value, $manipulation);
            } elseif (is_array($manipulation)) {
                $value = $this->applyArrayManipulation($value, $manipulation);
            }
        }

        return $value;
    }

    /**
     * Apply string-based manipulations
     */
    protected function applyStringManipulation(mixed $value, string $manipulation): mixed
    {
        return match ($manipulation) {
            'uppercase', 'upper' => strtoupper((string) $value),
            'lowercase', 'lower' => strtolower((string) $value),
            'title' => Str::title($value),
            'slug' => Str::slug($value),
            'studly' => Str::studly($value),
            'camel' => Str::camel($value),
            'snake' => Str::snake($value),
            'kebab' => Str::kebab($value),
            'trim' => trim((string) $value),
            'reverse' => strrev((string) $value),
            default => $value
        };
    }

    /**
     * Apply array-based manipulations
     */
    protected function applyArrayManipulation(mixed $value, array $manipulation): mixed
    {
        if (isset($manipulation['replace'])) {
            $value = str_replace(
                $manipulation['replace']['search'] ?? '',
                $manipulation['replace']['replace'] ?? '',
                $value
            );
        }

        if (isset($manipulation['prefix'])) {
            $value = $manipulation['prefix'].$value;
        }

        if (isset($manipulation['suffix'])) {
            $value .= $manipulation['suffix'];
        }

        if (isset($manipulation['limit'])) {
            return Str::limit($value, $manipulation['limit']);
        }

        return $value;
    }

    /**
     * Get specific field with manipulations
     */
    public function get(string $field, ...$manipulations): mixed
    {
        $property = Str::snake($field);
        $value = $this->attributes[$property] ?? null;

        if ($manipulations === []) {
            return $value;
        }

        return $this->applyManipulations($value, $manipulations);
    }

    /**
     * Convert the model to its array form.
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Check if a field exists
     */
    public function has(string $field): bool
    {
        $property = Str::snake($field);

        return isset($this->attributes[$property]);
    }

    /**
     * Get all available fields
     */
    public function getFields(): array
    {
        return array_keys($this->attributes);
    }
}
