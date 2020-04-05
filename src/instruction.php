<?php

declare(strict_types=1);

namespace Funktions\InstructionFuncs;

use Exception;
use Generator;
use function Funktions\GeneratorFuncs\ensure_generator;

/**
 * Return a value based on a condition
 */
function condition (bool $test, callable $truthy, callable $falsy)
{
    return call_user_func($test ? $truthy : $falsy);
}

/**
 * Loop over an iterable and yield new values
 */
function loop (iterable $iterable, callable $callable): Generator
{
    foreach ($iterable as $key => $item) {
        $generator = ensure_generator(
            call_user_func($callable, $item, $key)
        );
        foreach($generator as $value) {
            yield $value;
        }
        if ($generator->getReturn() === true) {
            break;
        }
    }
}

/**
 * Loop over an iterable and yield new values (with key preservation)
 */
function loop_preserve (iterable $iterable, callable $callable): Generator
{
    foreach ($iterable as $key => $item) {
        $generator = ensure_generator(
            call_user_func($callable, $item, $key)
        );
        yield from $generator;
        if ($generator->getReturn() === true) {
            break;
        }
    }
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
