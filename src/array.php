<?php

declare(strict_types=1);

namespace Funktions;

use Funktions\Exception\KeyNotFoundException;
use TypeError;

/**
 * Strict diff between two arrays by comparing the values at the same index.
 */
function array_diff_strict (array $array1, array $array2) : array
{
    if (count($array1) !== count($array2)) {
        throw new TypeError('Arrays must be of the same length');
    }
    return reduce(
        $array1,
        function (array $diff, $key, $value) use ($array2) : array {
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
 * Drop a part of an array (immutable `array_splice`).
 */
function array_drop (array $array, int $offset, int $length) : array
{
    array_splice($array, $offset, $length);
    return $array;
}

/**
 * Initialize multi-dimensional arrays.
 */
function array_fill_multi (int $dimensions, int $size, $value) : array
{
    $create = function (int $dimension, int $size, $value) use (&$create, $dimensions) : array {
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
 * Flatten an array by keeping an arbitrary minimum depth if necessary.
 */
function array_flatten(array $array, ?int $min_depth = null) : array
{
    $depth = function ($array) use (&$depth) : int {
        $level = 0;
        if (is_array($array[0])) {
            $level += 1 + $depth($array[0]);
        } else {
            $level += 1;
        }
        return $level;
    };
    if ($min_depth !== null) {
        if ($depth($array) === $min_depth) {
            return [$array];
        }
    }
    $newArray = [];
    foreach ($array as $key => $child) {
        if (is_array($child)) {
            $newArray = array_merge(
                $newArray,
                array_flatten($child, $min_depth)
            );
        } elseif (is_string($key)) {
            $newArray[$key] = $child;
        } else {
            $newArray[] = $child;
        }
    }
    return $newArray;
}

/**
 * Strict insersection between two arrays
 * by comparing the values at the same index.
 */
function array_intersect_strict (array $array1, array $array2) : array
{
    if (count($array1) !== count($array2)) {
        throw new TypeError('Arrays must be of the same length');
    }
    return reduce(
        $array1,
        function (array $diff, $key, $value) use ($array2) : array {
            if ($value === $array2[$key]) {
                $diff[] = $value;
            }
            return $diff;
        },
        []
    );
}

/**
 * Merge arrays recursively.
 */
function array_merge_recursive_unique (array ...$arrays) : array
{
    $merged = [];
    while ($arrays) {
        $array = array_shift($arrays);
        foreach ($array as $key => $value){
            if (is_string($key)) {
                if (is_array($value) &&
                    array_key_exists($key, $merged) &&
                    is_array($merged[$key])
                ) {
                    $merged[$key] = call_user_func(
                        __FUNCTION__,
                        $merged[$key],
                        $value
                    );
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
 * Move the array pointer to a specified key (mutable).
 */
function array_seek (array &$array, $key) : void
{
    reset($array);
    while(key($array) !== $key) {
        if (next($array) === false) {
            throw new KeyNotFoundException("'$key' key not found");
        }
    }
}

/**
 * Improved `array_splice()` with full string keys support when replacing.
 */
function array_substitute (
    array $array,
    int $offset,
    int $length,
    array $replacement
) : array
{
    return array_merge(
        array_slice($array, 0, $offset),
        $replacement,
        array_slice($array, $offset + $length)
    );
}

/**
 * Glue array elements together,
 * like `implode()` but with parameters in the right order.
 */
function glue (array $array, string $glue = '') : string
{
    return implode($glue, $array);
}

/**
 * Immutable `shuffle()`.
 */
function immut_array_shuffle (array $array) : array
{
    shuffle($array);
    return $array;
}

/**
 * Remove an element from an array (immutable `unset`).
 */
function immut_array_unset (array $array, $key) : array
{
    unset($array[$key]);
    return $array;
}

/**
 * Immutable `array_unshift()`.
 */
function immut_array_unshift (array $array, ...$elements) : array
{
    array_unshift($array, ...$elements);
    return $array;
}

/**
 * Immutable `arsort()`.
 */
function immut_arsort (array $array, int $flags = SORT_REGULAR) : array
{
    arsort($array, $flags);
    return $array;
}

/**
 * Immutable `asort()`.
 */
function immut_asort (array $array, int $flags = SORT_REGULAR) : array
{
    asort($array, $flags);
    return $array;
}

/**
 * Immutable `krsort()`.
 */
function immut_krsort (array $array, int $flags = SORT_REGULAR) : array
{
    krsort($array, $flags);
    return $array;
}

/**
 * Immutable `ksort()`.
 */
function immut_ksort (array $array, int $flags = SORT_REGULAR) : array
{
    ksort($array, $flags);
    return $array;
}

/**
 * Immutable `natcasesort()`.
 */
function immut_natcasesort (array $array) : array
{
    natcasesort($array);
    return $array;
}

/**
 * Immutable `natsort()`.
 */
function immut_natsort (array $array) : array
{
    natsort($array);
    return $array;
}

/**
 * Immutable `rsort()`.
 */
function immut_rsort (array $array, int $flags = SORT_REGULAR) : array
{
    rsort($array, $flags);
    return $array;
}

/**
 * Immutable `sort()`.
 */
function immut_sort (array $array, int $flags = SORT_REGULAR) : array
{
    sort($array, $flags);
    return $array;
}

/**
 * Immutable `uasort()`.
 */
function immut_uasort (array $array, callable $compare) : array
{
    uasort($array, $compare);
    return $array;
}

/**
 * Immutable `uksort()`.
 */
function immut_uksort (array $array, callable $compare) : array
{
    uksort($array, $compare);
    return $array;
}

/**
 * Immutable `usort()`.
 */
function immut_usort (array $array, callable $compare) : array
{
    usort($array, $compare);
    return $array;
}

/**
 * Immutable `array_push()`.
 */
function immut_array_push (array $array, ...$elements) : array
{
    array_push($array, ...$elements);
    return $array;
}

/**
 * Return the key of the maximum value.
 */
function kmax (array $array)
{
    return array_search(
        max($array),
        $array
    );
}

/**
 * Return the key of the minimum value.
 */
function kmin (array $array)
{
    return array_search(
        min($array),
        $array
    );
}
