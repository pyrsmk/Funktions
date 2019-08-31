<?php

declare(strict_types=1);

namespace Funktions;

/**
 * Capture output on a callable execution
 *
 * @param callable $callable
 * @return string
 */
function capture(callable $callable): string
{
    ob_start();
    call_user_func($callable);
    return ob_get_clean();
}

/**
 * Mute output on a callable execution
 *
 * @param callable $callable
 * @return mixed
 */
function mute(callable $callable)
{
    ob_start();
    $value = call_user_func($callable);
    ob_end_clean();
    return $value;
}
