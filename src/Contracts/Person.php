<?php

declare(strict_types=1);

namespace Daycode\Fictive\Contracts;

interface Person
{
    /**
     * defining the fullName method
     */
    public function fullName(?string $prompt = null): string;

    /**
     * defining the phoneNumber method
     */
    public function phoneNumber(?string $prompt = null): string;

    /**
     * defining the religion method
     */
    public function religion(?string $prompt = null): string;

    /**
     * defining the hobby method
     */
    public function hobby(?string $prompt = null): string;

    /**
     * defining the bloodGroup method
     */
    public function bloodGroup(?string $prompt = null): string;

    /**
     * defining the jobDesk method
     */
    public function jobDesc(?string $prompt = null): string;
}
