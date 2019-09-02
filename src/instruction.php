<?php

declare(strict_types=1);

namespace Funktions;

use Exception;
use Generator;
use function Funktions\ensure;

/**
 * Return a value based on a test
 *
 * @param boolean $test
 * @param callable $truthy
 * @param callable $falsy
 * @return mixed
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
 *
 * @param iterable $iterable
 * @param callable $callable
 * @return Generator
 */
function loop(iterable $iterable, callable $callable): Generator
{
    foreach ($iterable as $key => $item) {
        $generator = ensure(
            call_user_func($callable, $item, $key),
            'Generator'
        );
        foreach ($generator as $value) {
            yield $value;
        }
    }
}

/**
 * Loop over a generator until a condition is met
 *
 * @param callable $callable
 * @return Generator
 */
function loop_until(callable $callable): Generator
{
    do {
        $generator = ensure(
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
 *
 * @param callable $callable
 * @return Generator
 */
function loop_while(callable $callable): Generator
{
    do {
        $generator = ensure(
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
 *
 * @param callable $callable
 * @param array $exceptions
 * @return mixed
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
