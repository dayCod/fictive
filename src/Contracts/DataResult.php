<?php

declare(strict_types=1);

namespace Daycode\Fictive\Contracts;

interface DataResult
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
     * defining the dateOfBirth method
     */
    public function dateOfBirth(?string $prompt = null): string;

    /**
     * defining the maritalStatus method
     */
    public function maritalStatus(?string $prompt = null): string;

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
     * defining the latitude method
     */
    public function latitude(?string $prompt = null): string;

    /**
     * defining the longitude method
     */
    public function longitude(?string $prompt = null): string;

    /**
     * defining the country method
     */
    public function country(?string $prompt = null): string;

    /**
     * defining the state method
     */
    public function state(?string $prompt = null): string;

    /**
     * defining the city method
     */
    public function city(?string $prompt = null): string;

    /**
     * defining the streetName method
     */
    public function streetName(?string $prompt = null): string;

    /**
     * defining the address method
     */
    public function address(?string $prompt = null): string;

    /**
     * defining the postalCode method
     */
    public function postalCode(?string $prompt = null): string;
}
