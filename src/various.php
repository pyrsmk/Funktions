<?php

declare(strict_types=1);

namespace Funktions;

/**
 * Return a default value for a variable
 *
 * @param mixed $variable
 * @param mixed $default
 * @return mixed
 */
function alt($variable, $default)
{
    if ($variable === null) {
        return $default;
    }
    return $variable;
}

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
