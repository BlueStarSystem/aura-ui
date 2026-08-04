<?php

use BlueStarSystem\AuraUI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->in(__DIR__);

/**
 * Asserts a numeric value is within $delta of $expected. Used to compare
 * computed contrast ratios against published golden values, which are
 * quoted to two decimals and so need a tolerance rather than exact equality.
 */
expect()->extend('toBeWithin', function (float $expected, float $delta) {
    Assert::assertEqualsWithDelta($expected, $this->value, $delta);

    return $this;
});
