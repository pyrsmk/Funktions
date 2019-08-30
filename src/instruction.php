<?php

declare(strict_types=1);

namespace Funktions;

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
    foreach ($iterable as $item) {
        yield from ensure(
            call_user_func($callable, $item),
            'Generator'
        );
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
        yield from ensure(
            $generator = call_user_func($callable),
            'Generator'
        );
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
        yield from ensure(
            $generator = call_user_func($callable),
            'Generator'
        );
    }
    while($generator->getReturn() === true);
}
