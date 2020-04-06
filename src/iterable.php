<?php

declare(strict_types=1);

/**
 * Return true when at least one element matches the callable's condition.
 */
function one (iterable $iterable, callable $callable): bool
{
    foreach ($iterable as $key => $value) {
        if (call_user_func($callable, $key, $value) === true) {
            return true;
        }
    }
    return false;
}

/**
 * Return true when no element has matched the callable's condition.
 */
function none (iterable $iterable, callable $callable): bool
{
    foreach ($iterable as $key => $value) {
        if (call_user_func($callable, $key, $value) === true) {
            return false;
        }
    }
    return true;
}

/**
 * Select items that match the callable's condition.
 */
function select (iterable $iterable, callable $callable): Generator
{
    foreach ($iterable as $key => $value) {
        if (call_user_func($callable, $key, $value) === true) {
            yield $key => $value;
        }
    }
}

/**
 * Reject items that match the callable's condition.
 */
function reject (iterable $iterable, callable $callable): Generator
{
    foreach ($iterable as $key => $value) {
        if (call_user_func($callable, $key, $value) === false) {
            yield $key => $value;
        }
    }
}

/**
 * Like `array_map()` but works on any iterable and with key/value support.
 */
function map (iterable $iterable, callable $callable): Generator
{
    foreach ($iterable as $key => $value) {
        yield $key => call_user_func($callable, $key, $value);
    }
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
 * Alias to `iterator_to_array()`.
 */
function to_array (Traversable $iterator, bool $use_keys = true): array
{
    return iterator_to_array($iterator, $use_keys);
}

/**
 * Convert an iterable to a generator.
 */
function to_generator (iterable $items): Generator
{
    yield from $items;
}

/**
 * Ensure that the passed value will be a generator.
 */
function ensure_generator ($maybe_a_generator): Generator
{
    if (!is_a($maybe_a_generator, Generator::class)) {
        yield from [];
        return $maybe_a_generator;
    }
    yield from $maybe_a_generator;
    return $maybe_a_generator->getReturn();
}
