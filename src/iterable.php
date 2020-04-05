<?php

declare(strict_types=1);

namespace Funktions\IterableFuncs;

use Generator;

/**
 * Return true when at least one element matches the callable's condition
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
 * Return true when no element has matched the callable's condition
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
 * Select items that match the callable's condition
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
 * Reject items that match the callable's condition
 */
function reject (iterable $iterable, callable $callable): Generator
{
    foreach ($iterable as $key => $value) {
        if (call_user_func($callable, $key, $value) === false) {
            yield $key => $value;
        }
    }
}
