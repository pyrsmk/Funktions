<?php

declare(strict_types=1);

namespace Funktions;

use Exception;
use Generator;

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
    foreach ($iterable as $item) {
        $generator = call_user_func($callable, $item);
        if ($generator instanceof Generator === false) {
            throw new Exception('Callable must be a generator');
        }
        yield from $generator;
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
        $generator = call_user_func($callable);
        if ($generator instanceof Generator === false) {
            throw Exception('Callable must be a generator');
        }
        yield from $generator;
    }
    while($generator->getReturn() === false);
}
