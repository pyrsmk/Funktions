<?php

declare(strict_types=1);

namespace Funktions;

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
 * @return array
 */
function loop(iterable $iterable, callable $callable): array
{
    $array = [];
    foreach ($iterable as $item) {
        $generator = call_user_func($callable, $item);
        if ($generator instanceof Generator === false) {
            throw Exception('Callable must be a generator');
        }
        $array = array_merge($array, iterator_to_array($generator));
    }
    return $array;
}

/**
 * Loop in a generator until a returned condition
 *
 * @param callable $callable
 * @return array
 */
function loop_until(callable $callable): array
{
    $array = [];
    do {
        $generator = call_user_func($callable);
        if ($generator instanceof Generator === false) {
            throw Exception('Callable must be a generator');
        }
        $array = array_merge($array, iterator_to_array($generator));
    }
    while(!$generator->getReturn());
    return $array;
}
