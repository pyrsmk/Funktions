<?php

declare(strict_types=1);

namespace Funktions\ColorFuncs;

/**
 * Convert RGB to HSL color
 *
 * @param integer $r
 * @param integer $g
 * @param integer $b
 * @return array
 */
function rgb2hsl(int $r, int $g, int $b): array
{
    // Format
    if ($r < 0)     $r = 0;
    if ($r > 255)   $r = 255;
    if ($g < 0)     $g = 0;
    if ($g > 255)   $g = 255;
    if ($b < 0)     $b = 0;
    if ($b > 255)   $b = 255;
    // Normalize
    $r /= 255;
    $g /= 255;
    $b /= 255;
    // Init vars
    $min = min($r, $g, $b);
    $max = max($r, $g, $b);
    $delta = $max - $min;
    // Hue calculation
    switch ($max) {
        case $min   : $h = 0; break;
        case $r     : $h = (60 * (($g - $b) / $delta) + 360) % 360; break;
        case $g     : $h = 60 * (($b - $r) / $delta) + 120; break;
        case $b     : $h = 60 * (($r - $g) / $delta) + 240;
    }
    // Luminosity calculation
    $l = ($max + $min) / 2;
    // Saturation calculation
    if ($max == $min) {
        $s = 0;
    } else if ($l <= 0.5) {
        $s = $delta / ($l * 2);
    } else if ($l > 0.5) {
        $s = $delta / (2 - ($l * 2));
    }
    // Normalization
    $h = round($h);
    $s = round($s * 100);
    $l = round($l * 100);
    // Return color
    return [$h, $s, $l];
}

/**
 * Convert HSL to RGB color
 *
 * @param integer $h
 * @param integer $s
 * @param integer $l
 * @return array
 */
function hsl2rgb(int $h, int $s, int $l): array
{
    // Format
    if($h < 0)      $h = 0;
    if($h > 360)    $h = 360;
    if($s < 0)      $s = 0;
    if($s > 100)    $s = 100;
    if($l < 0)      $l = 0;
    if($l > 100)    $l = 100;
    // Normalize
    $h /= 360;
    $s /= 100;
    $l /= 100;
    // Init vars
    if ($l < 0.5) {
        $q = $l * (1 + $s);
    } else {
        $q = $l + $s - ($l * $s);
    }
    $p = (2 * $l) - $q;
    $delta = $q - $p;
    // Separate hues
    $hues = [
        $h + (1/3), // red hue
        $h,         // green hue
        $h - (1/3)  // blue hue
    ];
    // Colors calculation
    $i = 0;
    do {
        // Adjust
        if ($hues[$i] < 0) {
            ++$hues[$i];
        } else if ($hues[$i] > 1) {
            --$hues[$i];
        }
        // Final calculation
        if ($hues[$i] * 6 < 1) {
            $hues[$i] = $p + ($delta * 6 * $hues[$i]);
        } else if ($hues[$i] * 2 < 1) {
            $hues[$i] = $q;
        } else if ($hues[$i] * 3 < 2) {
            $hues[$i] = $p + ($delta * 6 * (2/3 - $hues[$i]));
        } else {
            $hues[$i] = $p;
        }
    } while (++$i < 3);
    // Normalization
    $r = round($hues[0] * 255);
    $g = round($hues[1] * 255);
    $b = round($hues[2] * 255);
    // Return the color
    return [$r, $g, $b];
}

/**
 * Convert RGB to HSV color
 *
 * @param integer $r
 * @param integer $g
 * @param integer $b
 * @return array
 */
function rgb2hsv(int $r, int $g, int $b): array
{
    // Format
    if ($r < 0)     $r = 0;
    if ($r > 255)   $r = 255;
    if ($g < 0)     $g = 0;
    if ($g > 255)   $g = 255;
    if ($b < 0)     $b = 0;
    if ($b > 255)   $b = 255;
    // Normalize
    $r /= 255;
    $g /= 255;
    $b /= 255;
    // Init vars
    $min = min($r, $g, $b);
    $max = max($r, $g, $b);
    $delta = $max - $min;
    // Hue calculation
    switch ($max) {
        case $min   : $h = 0; break;
        case $r     : $h = (60 * (($g - $b) / $delta) + 360) % 360; break;
        case $g     : $h = 60 * (($b - $r) / $delta) + 120; break;
        case $b     : $h = 60 * (($r - $g) / $delta) + 240;
    }
    // Saturation calculation
    if ($max == 0) {
        $s = 0;
    } else {
        $s = 1 - ($min / $max);
    }
    // Normalization
    $h = round($h);
    $s = round($s * 100);
    $v = round($max * 100);
    // Return the color
    return [$h, $s, $v];
}

/**
 * Convert HSV to RGB color
 *
 * @param integer $h
 * @param integer $s
 * @param integer $v
 * @return array
 */
function hsv2rgb(int $h, int $s, int $v): array
{
    // Format
    if ($h < 0 || $h >= 360)    $h = 0;
    if ($s < 0)                 $s = 0;
    if ($s > 100)               $s = 100;
    $s /= 100;
    if ($v < 0)     $v = 0;
    if ($v > 100)   $v = 100;
    // Init vars
    $teta = $h / 60;
    $delta = floor($teta) % 6;
    $f = $teta - $delta;
    $l = $v * (1 - $s);
    $m = $v * (1 - $f * $s);
    $n = $v * (1 - (1 - $f) * $s);
    // Convert
    switch($delta) {
        case 0:
            $r = floor($v * 2.55);
            $g = floor($n * 2.55);
            $b = floor($l * 2.55);
            break;
        case 1:
            $r = floor($m * 2.55);
            $g = floor($v * 2.55);
            $b = floor($l * 2.55);
            break;
        case 2:
            $r = floor($l * 2.55);
            $g = floor($v * 2.55);
            $b = floor($n * 2.55);
            break;
        case 3:
            $r = floor($l * 2.55);
            $g = floor($m * 2.55);
            $b = floor($v * 2.55);
            break;
        case 4:
            $r = floor($n * 2.55);
            $g = floor($l * 2.55);
            $b = floor($v * 2.55);
            break;
        case 5:
            $r = floor($v * 2.55);
            $g = floor($l * 2.55);
            $b = floor($m * 2.55);
            break;
    }
    // Return color
    return [$r, $g, $b];
}

/**
 * Convert RGB to HTML color
 *
 * @param integer $r
 * @param integer $g
 * @param integer $b
 * @return string
 */
function rgb2hex(int $r, int $g, int $b): string
{
    // Format
    if ($r < 0)     $r = 0;
    if ($r > 255)   $r = 255;
    if ($g < 0)     $g = 0;
    if ($g > 255)   $g = 255;
    if ($b < 0)     $b = 0;
    if ($b > 255)   $b = 255;
    // Convert
    $hex = '#' . dechex($r) . dechex($g) . dechex($b);
    // Return color
    return $hex;
}

/**
 * Convert HTML to RGB color
 *
 * @param string $html
 * @return array
 */
function hex2rgb(string $hex): array
{
    // Format
    $hex = ltrim($hex, '#');
    // Verify
    if (strlen($hex) !== 6) {
        trigger_error('HTML color must have a length of 6 hexadecimal characters', E_USER_ERROR);
    }
    // Convert
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    // Return color
    return [$r, $g, $b];
}
