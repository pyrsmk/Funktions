<?php

declare(strict_types=1);

namespace Funktions;

/**
 * Test if a regex matches against a string
 *
 * @param string $pattern
 * @param string $text
 * @param integer $flags
 * @return boolean
 */
function regex_test(string $pattern, string $text, int $flags = 0): bool
{
    return (bool) preg_match($pattern, $text, $matches, $flags);
}

/**
 * Count the number of matches for a regex in a string
 *
 * @param string $pattern
 * @param string $text
 * @param integer $flags
 * @return integer
 */
function regex_count(string $pattern, string $text, int $flags = 0): int
{
    return (int) preg_match($pattern, $text, $matches, $flags);
}

/**
 * Return the matches of a regex, for the first match
 *
 * @param string $pattern
 * @param string $text
 * @param integer $flags
 * @return array
 */
function regex_match(string $pattern, string $text, int $flags = 0): array
{
    if (!preg_match($pattern, $text, $matches, $flags)) {
        throw new Exception("'$pattern' has no match");
    }
    return $matches;
}

/**
 * Return all the matches of a regex
 *
 * @param string $pattern
 * @param string $text
 * @param integer $flags
 * @return array
 */
function regex_match_all(string $pattern, string $text, int $flags = 0): array
{
    if (!preg_match_all($pattern, $text, $matches, $flags)) {
        throw new Exception("'$pattern' has no match");
    }
    return $matches;
}
