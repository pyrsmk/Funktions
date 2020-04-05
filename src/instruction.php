<?php

declare(strict_types=1);

namespace Funktions\InstructionFuncs;

use Exception;
use Generator;
use function Funktions\MiscellaneousFuncs\ensure_type;

/**
 * Return a value based on a condition
 */
function condition (bool $test, callable $truthy, callable $falsy)
{
    return call_user_func($test ? $truthy : $falsy);
}

/**
 * Just loop over items
 */
function loop (iterable $iterable, callable $callable): void
{
    foreach ($iterable as $key => $item) {
        call_user_func($callable, $item, $key);
    }
}

/**
 * Loop over items and pass them to a generator with key preservation
 */
function loop_with_keys (iterable $iterable, callable $callable): Generator
{
    foreach ($iterable as $key => $item) {
        yield from call_user_func($callable, $item, $key);
    }
}

/**
 * Loop over a generator until a condition is met
 */
function loop_until (callable $callable): Generator
{
    do {
        $generator = call_user_func($callable);
        foreach ($generator as $value) {
            yield $value;
        }
    }
    while($generator->getReturn() === false);
}

/**
 * Loop over a generator while a condition is met
 */
function loop_while (callable $callable): Generator
{
    do {
        $generator = call_user_func($callable);
        foreach ($generator as $value) {
            yield $value;
        }
    }
    while($generator->getReturn() === true);
}

/**
 * Execute a callback and catch exceptions
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
