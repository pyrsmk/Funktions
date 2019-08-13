<?php

declare(strict_types=1);

namespace Funktions;

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
