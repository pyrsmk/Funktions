<?php

declare(strict_types=1);

namespace Funktions\InstructionFuncs;

use Exception;
use Generator;
use function Funktions\MiscellaneousFuncs\ensure_type;

/**
 * Return a value based on a condition
 */
function condition(bool $test, callable $truthy, callable $falsy)
{
    if ($test) {
        return call_user_func($truthy);
    }
    return call_user_func($falsy);
}

/**
 * Loop over items and pass them to a generator
 */
function loop(iterable $iterable, callable $callable): Generator
{
    foreach ($iterable as $key => $item) {
        $generator = ensure_type(
            call_user_func($callable, $item, $key),
            'Generator'
        );
        foreach ($generator as $value) {
            yield $value;
        }
    }
}

/**
 * Loop over items and pass them to a generator with key preservation
 */
function loop_with_keys(iterable $iterable, callable $callable): Generator
{
    foreach ($iterable as $key => $item) {
        yield from ensure_type(
            call_user_func($callable, $item, $key),
            'Generator'
        );
    }
}

/**
 * Loop over a generator until a condition is met
 */
function loop_until(callable $callable): Generator
{
    do {
        $generator = ensure_type(
            call_user_func($callable),
            'Generator'
        );
        foreach ($generator as $value) {
            yield $value;
        }
    }
    while($generator->getReturn() === false);
}

/**
 * Loop over a generator while a condition is met
 */
function loop_while(callable $callable): Generator
{
    do {
        $generator = ensure_type(
            call_user_func($callable),
            'Generator'
        );
        foreach ($generator as $value) {
            yield $value;
        }
    }
    while($generator->getReturn() === true);
}

/**
 * Execute a callback and catch exceptions
 */
function rescue(callable $callable, array $exceptions)
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
