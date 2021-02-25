<?php

declare(strict_types=1);

namespace Funktions;

/**
 * Collect garbage after callable execution.
 */
function memory_safe (callable $callable)
{
    $value = call_user_func($callable);
    gc_collect_cycles();
    return $value;
}
