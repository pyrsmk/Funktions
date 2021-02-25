<?php

declare(strict_types=1);

namespace Funktions;

use Exception;
use Generator;

/**
 * Return a value based on a condition.
 */
function condition (bool $test, callable $truthy, callable $falsy = null)
{
    $falsy = $falsy ?? fn () => null;
    return call_user_func($test ? $truthy : $falsy);
}

/**
 * Loop over an iterable and yield new values.
 */
function loop (iterable $iterable, callable $callable) : Generator
{
    foreach ($iterable as $key => $item) {
        $generator = ensure_generator(
            call_user_func($callable, $key, $item)
        );
        foreach($generator as $gen_key => $gen_item) {
            yield $gen_key => $gen_item;
        }
        if ($generator->getReturn() === false) {
            break;
        }
    }
}

/**
 * Execute a callback and catch exceptions.
 */
function rescue (callable $callable, array $exceptions)
{
    try {
        return call_user_func($callable);
    } catch (Exception $e) {
        foreach ($exceptions as $type => $e_callable) {
            if (is_a($e, $type, true)) {
                return call_user_func($e_callable);
            }
        }
        throw $e;
    }
}
