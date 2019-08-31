<?php

declare(strict_types=1);

namespace Funktions;

/**
 * Collect garbage after callable execution
 *
 * @param callable $callable
 * @return mixed
 */
function clean(callable $callable)
{
    $value = call_user_func($callable);
    gc_collect_cycles();
    return $value;
}

/**
 * Validate a value and return it
 *
 * @param mixed $value
 * @param string $type
 * @return mixed
 */
function ensure($value, string $type)
{
    if (ucfirst($type) === $type && gettype($value) === 'object') {
        return is_a($value, $type, true);
    } else {
        return gettype($value) === $type;
    }
}
