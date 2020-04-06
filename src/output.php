<?php

declare(strict_types=1);

/**
 * Capture output on a callable execution.
 */
function capture (callable $callable): string
{
    ob_start();
    call_user_func($callable);
    return ob_get_clean();
}

/**
 * Mute output on a callable execution.
 */
function mute (callable $callable)
{
    ob_start();
    $value = call_user_func($callable);
    ob_end_clean();
    return $value;
}

/**
 * Print a one-line text.
 */
function puts (string $text): void
{
    echo "$text\n";
}
