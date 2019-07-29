<?php

declare(strict_types=1);

namespace Funktions;

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
