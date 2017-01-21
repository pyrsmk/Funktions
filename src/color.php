<?php

/*
	Convert RGB color to HSL

	Parameters
		int $r  : red [0,255]
		int $g  : green [0,255]
		int $b  : blue [0,255]

	Return
		array   : the HSL color
*/
function rgb2hsl($r, $g, $b) {
	// Format
	$r = (int)$r;
	$g = (int)$g;
	$b = (int)$b;
	if($r < 0) $r = 0;
	if($r > 255) $r = 255;
	if($g < 0) $g = 0;
	if($g > 255) $g = 255;
	if($b < 0) $b = 0;
	if($b > 255) $b = 255;
	// Normalize
	$r /= 255;
	$g /= 255;
	$b /= 255;
	// Init vars
	$min = min($r, $g, $b);
	$max = max($r, $g, $b);
	$delta = $max - $min;
	// Hue calculation
	switch($max) {
		case $min   : $h = 0; break;
		case $r     : $h = (60 * (($g - $b) / $delta) + 360) % 360; break;
		case $g     : $h = 60 * (($b - $r) / $delta) + 120; break;
		case $b     : $h = 60 * (($r - $g) / $delta) + 240;
	}
	// Luminosity calculation
	$l = ($max + $min) / 2;
	// Saturation calculation
	if($max == $min) {
		$s = 0;
	}
	else if($l <= 0.5) {
		$s = $delta / ($l * 2);
	}
	else if($l > 0.5) {
		$s = $delta/(2-($l*2));
	}
	// Return HSL color
	return [round($h), round($s * 100), round($l * 100)];
}

/*
	Convert HSL color to RGB

	Parameters
		int $h  : hue [0,360]
		int $s  : saturation [0,100]
		int $l  : luminosity [0,100]

	Return
		array   : the RGB color
*/
function hsl2rgb($h, $s, $l) {
	// Format
	$h = (int)$h;
	$s = (int)$s;
	$l = (int)$l;
	if($h < 0) $h = 0;
	if($h > 360) $h = 360;
	if($s < 0) $s = 0;
	if($s > 100) $s = 100;
	if($l < 0) $l = 0;
	if($l > 100) $l = 100;
	// Normalize
	$h /= 360;
	$s /= 100;
	$l /= 100;
	// Init vars
	if($l < 0.5) {
		$q = $l * (1 + $s);
	}
	else {
		$q = $l + $s - ($l * $s);
	}
	$p = (2 * $l) - $q;
	$delta = $q - $p;
	// Separate hues
	$hues = [
		$h + (1/3),   // red hue
		$h,         // green hue
		$h - (1/3)    // blue hue
	];
	// Colors calculation
	$i = 0;
	do{
		// Adjust
		if($hues[$i] < 0) {
			++$hues[$i];
		}
		else if($hues[$i] > 1) {
			--$hues[$i];
		}
		// Final calculation
		if($hues[$i] * 6 < 1) {
			$hues[$i] = $p + ($delta * 6 * $hues[$i]);
		}
		else if($hues[$i] * 2 < 1) {
			$hues[$i] = $q;
		}
		else if($hues[$i] * 3 < 2) {
			$hues[$i] = $p + ($delta * 6 * (2/3 - $hues[$i]));
		}
		else {
			$hues[$i] = $p;
		}
	}
	while(++$i < 3);
	// Return the RGB color
	return [round($hues[0] * 255), round($hues[1] * 255), round($hues[2] * 255)];
}

/*
	Convert RGB color to HSV

	Parameters
		int $r  : red [0,255]
		int $g  : green [0,255]
		int $b  : blue [0,255]

	Return
		array   : the HSV color
*/
function rgb2hsv($r, $g, $b) {
	// Format
	$r = (int)$r;
	$g = (int)$g;
	$b = (int)$b;
	if($r < 0) $r = 0;
	if($r  >255) $r = 255;
	if($g < 0) $g = 0;
	if($g > 255) $g = 255;
	if($b < 0) $b = 0;
	if($b > 255) $b = 255;
	// Normalize
	$r /= 255;
	$g /= 255;
	$b /= 255;
	// Init vars
	$min = min($r, $g, $b);
	$max = max($r, $g, $b);
	$delta = $max - $min;
	// Hue calculation
	switch($max) {
		case $min   : $h = 0; break;
		case $r     : $h = (60 * (($g - $b) / $delta) + 360) % 360; break;
		case $g     : $h = 60 * (($b - $r) / $delta) + 120; break;
		case $b     : $h = 60 * (($r - $g) / $delta) + 240;
	}
	// Saturation calculation
	if($max == 0) {
		$s = 0;
	}
	else {
		$s = 1 - ($min / $max);
	}
	// Return the HSV color
	return [round($h), round($s * 100), round($max * 100)];
}

/*
	Convert HSV color to RGB

	Parameters
		int $h  : hue [0,360]
		int $s  : saturation [0,100]
		int $v  : value [0,100]

	Return
		array   : the RGB color
*/
function hsv2rgb($h, $s, $v) {
	// Format
	$h = (int)$h;
	$s = (int)$s;
	$v = (int)$v;
	if($h < 0 or $h >= 360) $h = 0;
	if($s < 0) $s = 0;
	if($s > 100) $s = 100;
	$s /= 100;
	if($v < 0) $v = 0;
	if($v > 100) $v = 100;
	// Init vars
	$teta = $h / 60;
	$delta = floor($teta) % 6;
	$f = $teta - $delta;
	$l = $v * (1 - $s);
	$m = $v * (1 - $f * $s);
	$n = $v * (1 - (1 - $f) * $s);
	// Convert
	switch($delta) {
		case 0: return [floor($v * 2.55), floor($n * 2.55), floor($l * 2.55)]; break;
		case 1: return [floor($m * 2.55), floor($v * 2.55), floor($l * 2.55)]; break;
		case 2: return [floor($l * 2.55), floor($v * 2.55), floor($n * 2.55)]; break;
		case 3: return [floor($l * 2.55), floor($m * 2.55), floor($v * 2.55)]; break;
		case 4: return [floor($n * 2.55), floor($l * 2.55), floor($v * 2.55)]; break;
		case 5: return [floor($v * 2.55), floor($l * 2.55), floor($m * 2.55)]; break;
	}
}

/*
	Convert RGB color to HTML

	Previous author
		Yetty (yettycz@gmail.com)

	Parameters
		int $r  : red [0,255]
		int $g  : green [0,255]
		int $b  : blue [0,255]

	Return
		string   : the HTML color
*/
function rgb2html($r, $g, $b) {
	// Format
	$r = (int)$r;
	$g = (int)$g;
	$b = (int)$b;
	if($r < 0) $r = 0;
	if($r > 255) $r = 255;
	if($g < 0) $g = 0;
	if($g > 255) $g = 255;
	if($b < 0) $b = 0;
	if($b > 255) $b = 255;
	// Convert
	return '#'.dechex($r).dechex($g).dechex($b);
}

/*
	Convert HTML color to RGB

	Previous author
		Yetty (yettycz@gmail.com)

	Parameters
		string $html    : the HTML color

	Return
		array           : the RGB color
*/
function html2rgb($html) {
	// Format
	$html = ltrim($html, '#');
	// Verify
	if(strlen($html) != 6) {
		trigger_error('HTML color must have a length of 6 hexadecimal characters', E_USER_ERROR);
	}
	// Convert
	return [
		hexdec(substr($html, 0, 2)),
		hexdec(substr($html, 2, 2)),
		hexdec(substr($html, 4, 2))
	];
}
