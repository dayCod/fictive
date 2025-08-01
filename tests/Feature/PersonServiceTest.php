<?php

use Daycode\Fictive\Fictive;

test('make sure the initFictive is callable', function (): void {
    $initFictive = app(Fictive::class)
        ->count(1)
        ->handlePersons();

    expect($initFictive)->toBeCallable();
});
