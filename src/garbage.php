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
