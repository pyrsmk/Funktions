<?php

declare(strict_types=1);

namespace Funktions;

use Generator;
use TypeError;
use Funktions\Exception\KeyNotFoundException;

/**
 * Strict diff between two arrays by comparing the values at the same index
 *
 * @param array $array1
 * @param array $array2
 * @return array
 */
function array_diff_strict(array $array1, array $array2): array
{
    if (count($array1) !== count($array2)) {
        throw new TypeError('Arrays must be of the same length');
    }
    return array_kvreduce(
        $array1,
        function (array $diff, $key, $value) use ($array2): array {
            if ($value !== $array2[$key]) {
                $diff[] = [
                    'offset' => $key,
                    'left' => $value,
                    'right' => $array2[$key],
                ];
            }
            return $diff;
        }, []
    );
}

/**
 * Drop a part of an array
 *
 * @param array $array
 * @param integer $offset
 * @param integer $length
 * @return array
 */
function array_drop(array $array, int $offset, int $length): array
{
    array_splice($array, $offset, $length);
    return $array;
}

/**
 * Initialize multi-dimensional arrays
 *
 * @param integer $dimensions
 * @param integer $size
 * @param mixed $value
 * @return array
 */
function array_fill_multi(int $dimensions, int $size, $value): array
{
    $create = function (int $dimension, int $size, $value) use (&$create, $dimensions): array {
        $array = [];
        foreach (range(1, $size) as $i) {
            if ($dimension < $dimensions) {
                $array[] = $create($dimension + 1, $size, $value);
            } else {
                $array[] = $value;
            }
        }
        return $array;
    };
    return $create(1, $size, $value);
}

/**
 * Strict insersection between two arrays by comparing the values at the same index
 *
 * @param array $array1
 * @param array $array2
 * @return array
 */
function array_intersect_strict(array $array1, array $array2): array
{
    if (count($array1) !== count($array2)) {
        throw new TypeError('Arrays must be of the same length');
    }
    return array_kvreduce(
        $array1,
        function (array $diff, $key, $value) use ($array2): array {
            if ($value === $array2[$key]) {
                $diff[] = $value;
            }
            return $diff;
        }, []
    );
}

/**
 * array_map with key/value support
 *
 * @param array $array
 * @param callable $callable
 * @return array
 */
function array_kvmap(array $array, callable $callable): array
{
    return array_map($callable, $array, array_keys($array));
}

/**
 * Alias to array_kvmap()
 *
 * @param array $array
 * @param callable $callback
 * @return array
 */
function map(array $array, callable $callable): array
{
    return array_kvmap($array, $callable);
}

/**
 * array_reduce with key/value support
 *
 * @param array $array
 * @param callable $callable
 * @param mixed $initial
 * @return mixed
 */
function array_kvreduce(array $array, callable $callable, $initial = null)
{
    $carry = $initial;
    foreach ($array as $key => $value) {
        $carry = call_user_func($callable, $carry, $value, $key);
    }
    return $carry;
}

/**
 * Alias to array_kvreduce()
 *
 * @param array $array
 * @param callable $callback
 * @return array
 */
function reduce(array $array, callable $callable): array
{
    return array_kvreduce($array, $callable);
}

/**
 * Merge arrays recursively
 *
 * @param array ...$arrays
 * @return array
 */
function array_merge_recursive_unique(array ...$arrays): array
{
    $merged = [];
    while ($arrays) {
        $array = array_shift($arrays);
        foreach ($array as $key => $value){
            if (is_string($key)) {
                if (is_array($value) &&
                    array_key_exists($key, $merged) && is_array($merged[$key])
                ) {
                    $merged[$key] = call_user_func(__FUNCTION__, $merged[$key], $value);
                } else {
                    $merged[$key] = $value;
                }
            } else {
                $merged[] = $value;
            }
        }
    }
    return $merged;
}

/**
 * Convert an array to a generator
 *
 * @param array $items
 * @return Generator
 */
function array_to_generator(array $items): Generator
{
    foreach ($items as $key => $item) {
        yield $key => $item;
    }
}

/**
 * Improved array_splice() with full string keys support when replacing
 *
 * @param array $array
 * @param integer $offset
 * @param integer $length
 * @param array $replacement
 * @return array
 */
function array_substitute(array $array, int $offset, int $length, array $replacement): array
{
    return array_merge(
        array_slice($array, 0, $offset),
        $replacement,
        array_slice($array, $offset + $length)
    );
}

/**
 * Immutable sort()
 *
 * @param array $array
 * @param integer $flags
 * @return array
 */
function array_sort(array $array, int $flags = SORT_REGULAR): array
{
    sort($array, $flags);
    return $array;
}

/**
 * Immutable asort()
 *
 * @param array $array
 * @param integer $flags
 * @return array
 */
function array_asort(array $array, int $flags = SORT_REGULAR): array
{
    asort($array, $flags);
    return $array;
}

/**
 * Immutable arsort()
 *
 * @param array $array
 * @param integer $flags
 * @return array
 */
function array_arsort(array $array, int $flags = SORT_REGULAR): array
{
    arsort($array, $flags);
    return $array;
}

/**
 * Immutable rsort()
 *
 * @param array $array
 * @param integer $flags
 * @return array
 */
function array_rsort(array $array, int $flags = SORT_REGULAR): array
{
    rsort($array, $flags);
    return $array;
}

/**
 * Immutable ksort()
 *
 * @param array $array
 * @param integer $flags
 * @return array
 */
function array_ksort(array $array, int $flags = SORT_REGULAR): array
{
    ksort($array, $flags);
    return $array;
}

/**
 * Immutable krsort()
 *
 * @param array $array
 * @param integer $flags
 * @return array
 */
function array_krsort(array $array, int $flags = SORT_REGULAR): array
{
    krsort($array, $flags);
    return $array;
}

/**
 * Immutable usort()
 *
 * @param array $array
 * @param callable $compare
 * @return array
 */
function array_usort(array $array, callable $compare): array
{
    usort($array, $compare);
    return $array;
}

/**
 * Immutable uksort()
 *
 * @param array $array
 * @param callable $compare
 * @return array
 */
function array_uksort(array $array, callable $compare): array
{
    uksort($array, $compare);
    return $array;
}

/**
 * Immutable uasort()
 *
 * @param array $array
 * @param callable $compare
 * @return array
 */
function array_uasort(array $array, callable $compare): array
{
    uasort($array, $compare);
    return $array;
}

/**
 * Immutable natsort()
 *
 * @param array $array
 * @return array
 */
function array_natsort(array $array): array
{
    natsort($array);
    return $array;
}

/**
 * Immutable natcasesort()
 *
 * @param array $array
 * @return array
 */
function array_natcasesort(array $array): array
{
    natcasesort($array);
    return $array;
}

/**
 * Glue array elements
 *
 * @param array $array
 * @return string
 */
function glue(array $array): string
{
    return implode('', $array);
}

/**
 * Return the key of the maximum value
 *
 * @param array $array
 * @return void
 */
function kmax(array $array)
{
    return array_search(
        max($array),
        $array
    );
}

/**
 * Return the key of the minimum value
 *
 * @param array $array
 * @return void
 */
function kmin(array $array)
{
    return array_search(
        min($array),
        $array
    );
}

/**
 * Move the array pointer (mutable)
 *
 * @param array $array
 * @param integer|string $key
 * @return void
 */
function seek(array &$array, $key): void
{
    reset($array);
    while(key($array) !== $key) {
        if (next($array) === false) {
            throw new KeyNotFoundException("'$key' key not found");
        }
    }
}
