<?php

declare(strict_types=1);

namespace Funktions\MiscellaneousFuncs;

/**
 * Collect garbage after callable execution.
 */
function mem_cleaned (callable $callable)
{
    $value = call_user_func($callable);
    gc_collect_cycles();
    return $value;
}
