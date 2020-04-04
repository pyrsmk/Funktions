<?php

declare(strict_types=1);

namespace Funktions\NumberFuncs;

/**
 * Verify if the value is even
 *
 * @param integer $value
 * @return boolean
 */
function is_even(int $value): bool
{
    return $value % 2 === 0;
}

/**
 * Verify if the value is odd
 *
 * @param integer $value
 * @return boolean
 */
function is_odd(int $value): bool
{
    return $value % 2 !== 0;
}

/**
 * Bound a number to a minimum value
 *
 * @param float $value
 * @param float $min
 * @return float
 */
function above(float $value, float $min): float
{
    return $value < $min ? $min : $value;
}

/**
 * Bound a number to a maximum value
 *
 * @param float $value
 * @param float $max
 * @return float
 */
function under(float $value, float $max): float
{
    return $value > $max ? $max : $value;
}
