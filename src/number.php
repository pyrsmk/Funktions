<?php

declare(strict_types=1);

/**
 * Verify if the value is even.
 */
function is_even (int $value): bool
{
    return $value % 2 === 0;
}

/**
 * Verify if the value is odd.
 */
function is_odd (int $value): bool
{
    return $value % 2 !== 0;
}

/**
 * Bound a number to a minimum value.
 */
function above (float $value, float $min): float
{
    return $value < $min ? $min : $value;
}

/**
 * Bound a number to a maximum value.
 */
function under (float $value, float $max): float
{
    return $value > $max ? $max : $value;
}
