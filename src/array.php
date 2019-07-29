<?php

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
