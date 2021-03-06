<?php

declare(strict_types=1);

namespace Funktions;

use Funktions\Exception\UnexpectedErrorException;
use Funktions\Exception\InvalidFileException;

/**
 * Get human-readable file permissions.
 */
function human_fileperms (string $path) : string
{
    $perms = fileperms($path);
    // Socket
    if (($perms & 0xC000) === 0xC000)       $type = 's';
    // Symbolic Link
    else if (($perms & 0xA000) === 0xA000)  $type = 'l';
    // Regular
    else if (($perms & 0x8000) === 0x8000)  $type = '-';
    // Block
    else if (($perms & 0x6000) === 0x6000)  $type = 'b';
    // Directory
    else if (($perms & 0x4000) === 0x4000)  $type = 'd';
    // Character
    else if (($perms & 0x2000) === 0x2000)  $type = 'c';
    // FIFO pipe
    else if (($perms & 0x1000) === 0x1000)  $type = 'p';
    // Unknown
    else                                    $type = 'u';
    // Owner
    $owner = (($perms & 0x0100) ? 'r' : '-');
    $owner .= (($perms & 0x0080) ? 'w' : '-');
    $owner .= (($perms & 0x0040) ?
        (($perms & 0x0800) ? 's' : 'x') :
        (($perms & 0x0800) ? 'S' : '-'));
    // Group
    $group = (($perms & 0x0020) ? 'r' : '-');
    $group .= (($perms & 0x0010) ? 'w' : '-');
    $group .= (($perms & 0x0008) ?
        (($perms & 0x0400) ? 's' : 'x') :
        (($perms & 0x0400) ? 'S' : '-'));
    // All
    $all = (($perms & 0x0004) ? 'r' : '-');
    $all .= (($perms & 0x0002) ? 'w' : '-');
    $all .= (($perms & 0x0001) ?
        (($perms & 0x0200) ? 't' : 'x') :
        (($perms & 0x0200) ? 'T' : '-'));
    // Return permissions
    return "$type$owner$group$all";
}

/**
 * Get human-readable file size.
 */
function human_filesize (string $path) : string
{
    $bytes = filesize($path);
    $units = ['b', 'Kb', 'Mb', 'Gb', 'Tb', 'Eb'];
    for ($i = count($units) - 1; $i >= 0; --$i) {
        if ($bytes >= pow(1024, $i)) {
            return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
        }
    }
    throw new UnexpectedErrorException("Unable to translate filesize for '$path'");
}

/**
 * Scan a directory without '.' and '..'.
 */
function lessdir (string $dir) : array
{
    if (file_exists($dir) === false) {
        return [];
    } else {
        return array_slice(scandir($dir), 2);
    }
}

/**
 * Get a file's mime type.
 */
function mimetype (string $path) : string
{
    if (filter_var($path, FILTER_VALIDATE_URL)) {
        $request = curl_init($path);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_NOBODY, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($request);
        $type = curl_getinfo($request, CURLINFO_CONTENT_TYPE);
        curl_close($request);
    } else {
        if (!is_file($path)) {
            throw new InvalidFileException("'$path' is not a file");
        }
        if (!is_readable($path)) {
            throw new InvalidFileException("'$path' is not readable");
        }
        $finfo = finfo_open(FILEINFO_MIME);
        $type = finfo_file($finfo,$path);
        finfo_close($finfo);
        if (empty($type)) {
            throw new UnexpectedErrorException("Cannot retrieve mime type with fileinfo extension");
        }
    }
    if (!$type) {
        return 'application/octet-stream';
    } else {
        $type = explode(';', $type);
        return $type[0];
    }
}

/**
 * Remove a directory recursively.
 */
function rrmdir (string $path) : void
{
    if ($path[strlen($path) - 1] == '/') {
        $path = substr($path, 0, -1);
    }
    if (is_dir($path)) {
        foreach (lessdir($path) as $file) {
            if (is_dir("$path/$file")) {
                rrmdir("$path/$file");
            } else {
                unlink("$path/$file");
            }
        }
        rmdir($path);
    }
}
