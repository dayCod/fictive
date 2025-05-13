<?php

use Daycode\Fictive\Example;

it('foo', function (): void {
    $example = new Example;

    $result = $example->isFictive();

    expect($result)->toBe(true);
});
