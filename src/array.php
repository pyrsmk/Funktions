<?php

declare(strict_types=1);

namespace Funktions\ArrayFuncs;

use TypeError;
use Funktions\Exception\KeyNotFoundException;

/**
 * Strict diff between two arrays by comparing the values at the same index
 */
function array_diff_strict (array $array1, array $array2): array
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
        },
        []
    );
}

/**
 * Drop a part of an array
 */
function array_drop (array $array, int $offset, int $length): array
{
    array_splice($array, $offset, $length);
    return $array;
}

/**
 * Initialize multi-dimensional arrays
 */
function array_fill_multi (int $dimensions, int $size, $value): array
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
 */
function array_intersect_strict (array $array1, array $array2): array
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
        },
        []
    );
}

/**
 * `array_map()` with key/value support
 */
function array_kvmap (array $array, callable $callable): array
{
    return array_map($callable, $array, array_keys($array));
}

/**
 * Alias to `array_kvmap()`
 */
function map (array $array, callable $callable): array
{
    return array_kvmap($array, $callable);
}

/**
 * `array_reduce()` with key/value support
 */
function array_kvreduce (array $array, callable $callable, $initial = null)
{
    $carry = $initial;
    foreach ($array as $key => $value) {
        $carry = call_user_func($callable, $carry, $value, $key);
    }
    return $carry;
}

/**
 * Alias to `array_kvreduce()`
 */
function reduce (array $array, callable $callable, $initial = null)
{
    return array_kvreduce($array, $callable, $initial);
}

/**
 * Merge arrays recursively
 */
function array_merge_recursive_unique (array ...$arrays): array
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
 * Improved `array_splice()` with full string keys support when replacing
 */
function array_substitute (array $array, int $offset, int $length, array $replacement): array
{
    return array_merge(
        array_slice($array, 0, $offset),
        $replacement,
        array_slice($array, $offset + $length)
    );
}

/**
 * Immutable `sort()`
 */
function array_sort (array $array, int $flags = SORT_REGULAR): array
{
    sort($array, $flags);
    return $array;
}

/**
 * Immutable `asort()`
 */
function array_asort (array $array, int $flags = SORT_REGULAR): array
{
    asort($array, $flags);
    return $array;
}

/**
 * Immutable `arsort()`
 */
function array_arsort (array $array, int $flags = SORT_REGULAR): array
{
    arsort($array, $flags);
    return $array;
}

/**
 * Immutable `rsort()`
 */
function array_rsort (array $array, int $flags = SORT_REGULAR): array
{
    rsort($array, $flags);
    return $array;
}

/**
 * Immutable `ksort()`
 */
function array_ksort (array $array, int $flags = SORT_REGULAR): array
{
    ksort($array, $flags);
    return $array;
}

/**
 * Immutable `krsort()`
 */
function array_krsort (array $array, int $flags = SORT_REGULAR): array
{
    krsort($array, $flags);
    return $array;
}

/**
 * Immutable `usort()`
 */
function array_usort (array $array, callable $compare): array
{
    usort($array, $compare);
    return $array;
}

/**
 * Immutable `uksort()`
 */
function array_uksort (array $array, callable $compare): array
{
    uksort($array, $compare);
    return $array;
}

/**
 * Immutable `uasort()`
 */
function array_uasort (array $array, callable $compare): array
{
    uasort($array, $compare);
    return $array;
}

/**
 * Immutable `natsort()`
 */
function array_natsort (array $array): array
{
    natsort($array);
    return $array;
}

/**
 * Immutable `natcasesort()`
 */
function array_natcasesort (array $array): array
{
    natcasesort($array);
    return $array;
}

/**
 * Glue array elements together,
 * like `implode()` but with parameters in the right order
 */
function glue (array $array, string $glue = ''): string
{
    return implode($glue, $array);
}

/**
 * Return the key of the maximum value
 */
function kmax (array $array)
{
    return array_search(
        max($array),
        $array
    );
}

/**
 * Return the key of the minimum value
 */
function kmin (array $array)
{
    return array_search(
        min($array),
        $array
    );
}

/**
 * Move the array pointer to a specified key (mutable)
 */
function seek (array &$array, $key): void
{
    reset($array);
    while(key($array) !== $key) {
        if (next($array) === false) {
            throw new KeyNotFoundException("'$key' key not found");
        }
    }
}
