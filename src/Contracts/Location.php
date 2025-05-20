<?php

declare(strict_types=1);

namespace Daycode\Fictive\Contracts;

interface Location
{
    /**
     * defining the latitude method
     */
    public function latitude(?string $prompt = null): string;

    // /**
    //  * defining the longitude method
    //  */
    // public function longitude(?string $prompt = null): string;

    // /**
    //  * defining the country method
    //  */
    // public function country(?string $prompt = null): string;

    // /**
    //  * defining the state method
    //  */
    // public function state(?string $prompt = null): string;

    // /**
    //  * defining the city method
    //  */
    // public function city(?string $prompt = null): string;

    // /**
    //  * defining the streetName method
    //  */
    // public function streetName(?string $prompt = null): string;

    // /**
    //  * defining the address method
    //  */
    // public function address(?string $prompt = null): string;

    // /**
    //  * defining the postalCode method
    //  */
    // public function postalCode(?string $prompt = null): string;
}
