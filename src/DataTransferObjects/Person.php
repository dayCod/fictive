<?php

declare(strict_types=1);

namespace Daycode\Fictive\DataTransferObjects;

use Illuminate\Support\Str;

class Person
{
    public function __construct(protected array $attributes) {}

    public function __call(string $method, array $arguments): mixed
    {
        $property = Str::snake($method);

        return $this->attributes[$property] ?? null;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
