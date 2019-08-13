<?php

declare(strict_types=1);

namespace Funktions;

/**
 * Converts a string to camel case
 *
 * @param string $string
 * @return string
 */
function mb_to_camelcase(string $string): string
{
    return mb_ereg_replace('-', '', ucwords($string, '-'));
}

/**
 * Capitalize all words in a string
 *
 * @param string $string
 * @param string $encoding
 * @return string
 */
function mb_ucwords(string $string, ?string $encoding = null): string
{
    return mb_convert_case(
        $string,
        MB_CASE_TITLE,
        $encoding ?? mb_internal_encoding()
    );
}

/**
 * Capitalize a string
 *
 * @param string $string
 * @param string $encoding
 * @return string
 */
function mb_ucfirst(string $string, ?string $encoding = null): string
{
    $encoding = $encoding ?? mb_internal_encoding();
    $first = mb_strtoupper(
        mb_substr($string, 0, 1, $encoding),
        $encoding
    );
    return $first . mb_substr($string, 1, null, $encoding);
}

/**
 * Uncapitalize a string
 *
 * @param string $string
 * @param string $encoding
 * @return string
 */
function mb_lcfirst($string, ?string $encoding = null): string
{
    $encoding = $encoding ?? mb_internal_encoding();
    $first = mb_strtolower(
        mb_substr($string, 0, 1, $encoding),
        $encoding
    );
    return $first . mb_substr($string, 1, null, $encoding);
}

/**
* Truncate a string
*
* @param string $string
* @param int $length
* @param string $remainder
* @return string
*/
function mb_truncate(string $string, int $length, ?string $encoding = null): string
{
   if (mb_strlen($string) <= $length) {
       return $string;
   }
   $encoding = $encoding ?? mb_internal_encoding();
   $truncated = mb_substr(
       mb_substr($string . ' ', 0, $length, $encoding),
       0,
       mb_strrpos($string, ' ', 0, $encoding),
       $encoding
    );
   return $truncated . '...';
}

/**
 * Generate a random hash
 * https://stackoverflow.com/questions/1846202/php-how-to-generate-a-random-unique-alphanumeric-string
 *
 * @param int $length
 * @return string
 */
function random_hash(int $length = 5): string
{
    return bin2hex(random_bytes($length));
}

/**
 * Generate a random v4 UUID
 * https://php.net/manual/en/function.uniqid.php#94959
 *
 * @return string
 */
function uuid4(): string
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),
        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,
        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,
        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}
