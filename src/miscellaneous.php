<?php

declare(strict_types=1);

namespace Funktions\MiscellaneousFuncs;

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
 * Validate a value's type
 *
 * @param mixed $value
 * @param string $type
 * @return mixed
 */
function ensure($value, string $type)
{
    if (ucfirst($type) === $type && gettype($value) === 'object') {
        if (is_a($value, $type, true) === false) {
            throw new InvalidValueTypeException(
                sprintf("'%s' class descendent expected, '%s' met", $type, get_class($value))
            );
        }
    } else {
        if (gettype($value) !== $type) {
            throw new InvalidValueTypeException(
                sprintf("'%s' type expected, '%s' met", $type, gettype($value))
            );
        }
    }
    return $value;
}
