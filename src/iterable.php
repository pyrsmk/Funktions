<?php

declare(strict_types=1);

namespace Funktions;

use ArrayAccess;
use Generator;
use Traversable;

/**
 * Return true when all elements match the callable's condition.
 */
function all (iterable $iterable, callable $callable) : bool
{
    foreach ($iterable as $key => $value) {
        if (call_user_func($callable, $key, $value) !== true) {
            return false;
        }
    }
    return true;
}

/**
 * Return true when at least one element matches the callable's condition.
 */
function any (iterable $iterable, callable $callable) : bool
{
    foreach ($iterable as $key => $value) {
        if (call_user_func($callable, $key, $value) === true) {
            return true;
        }
    }
    return false;
}

/**
 * Ensure that the passed value will be a generator. If the value is not a
 * generator, a dummy one is returned with no values and the passed value is
 * returned as the return value of the dummy generator.
 */
function ensure_generator ($may_be_a_generator) : Generator
{
    if (!is_a($may_be_a_generator, Generator::class)) {
        yield from [];
        return $may_be_a_generator;
    }
    yield from $may_be_a_generator;
    return $may_be_a_generator->getReturn();
}

/**
 * Enumerate elements in an iterable.
 */
function enumerate (iterable $iterable, ?callable $callable = null) : int
{
    if ($callable === null) {
        if (is_countable($iterable)) {
            return count($iterable);
        }
        return reduce($iterable, fn($n) => $n + 1, 0);
    }
    return reduce(
        $iterable,
        function ($n, $key, $value) use ($callable) {
            if (call_user_func($callable, $key, $value) === true) {
                $n += 1;
            }
            return $n;
        },
        0
    );
}

/**
 * Return the first element of an iterable.
 * Note that the iterable's pointer will be resetted.
 */
function first (iterable $iterable)
{
    if (is_array($iterable)) {
        reset($iterable);
        return current($iterable);
    }
    $iterable->rewind();
    return $iterable->current();
}

/**
 * Convert an iterable to a generator.
 */
function iterable_to_generator (iterable $items) : Generator
{
    yield from $items;
}

/**
 * Convert an iterator to an array (alias to `iterator_to_array()`).
 */
function itoa (Traversable $iterator, bool $use_keys = true) : array
{
    return iterator_to_array($iterator, $use_keys);
}

/**
 * Convert an iterable to a generator (alias to `iterable_to_generator()`).
 */
function itog (iterable $items) : Generator
{
    yield from iterable_to_generator($items);
}

/**
 * Return the last element of an iterable.
 * Note that:
 *     - if the iterable is an array, then its pointer will be resetted
 *     - if the iterable is not an array, it will be converted to one,
 *       then have in mind that a complete iteration will be done before
 *       being able to get its last element
 */
function last (iterable $iterable)
{
    if (!is_array($iterable)) {
        $iterable = iterator_to_array($iterable);
    }
    $value = end($iterable);
    reset($iterable);
    return $value;
}

/**
 * Like `array_map()` but works on any iterable and with key/value support.
 */
function map (iterable $iterable, callable $callable) : Generator
{
    foreach ($iterable as $key => $value) {
        yield $key => call_user_func($callable, $key, $value);
    }
}

/**
 * Return true when no element has matched the callable's condition.
 */
function none (iterable $iterable, callable $callable) : bool
{
    foreach ($iterable as $key => $value) {
        if (call_user_func($callable, $key, $value) === true) {
            return false;
        }
    }
    return true;
}

/**
 * Extract lines from an iterable based on the requested keys.
 */
function pluck (iterable $iterable, string ...$keys) : Generator
{
    if (is_array($iterable) && count($keys) == 1) {
        return array_column($iterable, first($keys));
    }
    return loop($iterable, function ($_k, array $line) use ($keys) {
        if (count($keys) == 1) {
            yield value($line, first($keys));
        } else {
            yield map(
                $keys,
                fn($key) => value($line, $key)
            );
        }
    });
}

/**
 * Like `array_reduce()` but works on any iterable and with key/value support.
 */
function reduce (iterable $iterable, callable $callable, $initial = null)
{
    $carry = $initial;
    foreach ($iterable as $key => $value) {
        $carry = call_user_func($callable, $carry, $key, $value);
    }
    return $carry;
}

/**
 * Reject items that match the callable's condition.
 */
function reject (iterable $iterable, callable $callable) : Generator
{
    foreach ($iterable as $key => $value) {
        if (call_user_func($callable, $key, $value) === false) {
            yield $key => $value;
        }
    }
}

/**
 * Select items that match the callable's condition.
 */
function select (iterable $iterable, callable $callable) : Generator
{
    foreach ($iterable as $key => $value) {
        if (call_user_func($callable, $key, $value) === true) {
            yield $key => $value;
        }
    }
}

/**
 * Retrieve a value from an iterable with a specified key.
 * Note that it should be used with a hash or an array because iterating
 * other an iterable for searching an element is not efficient at all.
 */
function value (iterable $iterable, string $key)
{
    if (is_array($iterable) || $iterable instanceof ArrayAccess) {
        return $iterable[$key];
    }
    if (property_exists($iterable, $key)) {
        return $iterable->$key;
    }
    foreach ($iterable as $k => $v) {
        if ($key === $k) {
            return $v;
        }
    }
}
