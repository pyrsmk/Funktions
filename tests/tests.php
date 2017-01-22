<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

########################################################### Import

require 'vendor/autoload.php';

$path = '../src/';
foreach(array_slice(scandir($path), 2) as $file) {
	require $path.$file;
}

########################################################### array.php

$minisuite = new MiniSuite\Suite('array.php');

$a1 = [
    88 => 1,
    'foo' => 2,
    'bar' => [4],
    'x' => 5,
    'z' => [
        6,
        'm' => 'hi'
    ]
];

$a2 = [
    99 => 7,
    'foo' => [8],
    'bar' => 9,
    'y' => 10,
    'z' => [
        'm' => 'bye',
        11
    ]
];

$a3 = [
    'z' => [
        'm' => 'ciao'
    ]
];

$result = [
    1,
    'foo' => [8],
    'bar' => 9,
    'x' => 5,
    'z' => [
        6,
        'm' => 'ciao',
        11
    ],
    7,
    'y' => 10
];

$minisuite->expects('array_merge_recursive_unique()')
          ->that(array_merge_recursive_unique($a1, $a2, $a3))
          ->equals($result);

########################################################### color.php

$minisuite = new MiniSuite\Suite('color.php');

$minisuite->expects('rgb2hsl()')
          ->that(rgb2hsl(188,58,58))
          ->equals(array(0,53,48));

$minisuite->expects('hsl2rgb()')
          ->that(hsl2rgb(0,53,48))
          ->equals(array(187,58,58));

$minisuite->expects('rgb2hsv()')
          ->that(rgb2hsv(188,58,58))
          ->equals(array(0,69,74));

$minisuite->expects('hsv2rgb()')
          ->that(hsv2rgb(0,69,74))
          ->equals(array(188,58,58));

$minisuite->expects('rgb2html()')
          ->that(rgb2html(188,58,58))
          ->equals('#bc3a3a');

$minisuite->expects('html2rgb()')
          ->that(html2rgb('#bc3a3a'))
          ->equals(array(188,58,58));

########################################################### system.php

$minisuite = new MiniSuite\Suite('system.php');

$minisuite->expects('human_filesize()')
          ->that(human_filesize('files/sample.txt'))
          ->equals('9 b');

$minisuite->expects('lessdir()')
          ->that(count(lessdir('.')))
          ->equals(5);

$minisuite->expects('human_fileperms() : files/')
          ->that(human_fileperms('files/'))
          ->equals('drwxrwxrwx');

$minisuite->expects('human_fileperms() : files/sample.txt')
          ->that(human_fileperms('files/sample.txt'))
          ->equals('-rw-rw-rw-');

$minisuite->expects('mimetype() : files/sample.txt')
          ->that(mimetype('files/sample.txt'))
          ->equals('text/plain');

$minisuite->expects('mimetype() : files/sample.jpg')
          ->that(mimetype('files/sample.jpg'))
          ->equals('image/jpeg');

$minisuite->expects('mimetype() : http://img13.deviantart.net/f3dc/i/2017/021/1/8/breathe_by_fukari-daw6ae3.jpg')
          ->that(mimetype('http://img13.deviantart.net/f3dc/i/2017/021/1/8/breathe_by_fukari-daw6ae3.jpg'))
          ->equals('image/jpeg');