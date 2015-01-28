<?php

ini_set('display_errors',true);
error_reporting(E_ALL);

########################################################### Imports

require 'vendor/autoload.php';

$path='../src/';
foreach(array_slice(scandir($path),2) as $file){
	require $path.$file;
}

########################################################### Instantiate

$minisuite=new MiniSuite('Funktions');

########################################################### array.php

$minisuite->group('array.php',function() use($minisuite){

	$a1=array(
		88 => 1,
		'foo' => 2,
		'bar' => array(4),
		'x' => 5,
		'z' => array(
			6,
			'm' => 'hi'
		)
	);

	$a2=array(
		99 => 7,
		'foo' => array(8),
		'bar' => 9,
		'y' => 10,
		'z' => array(
			'm' => 'bye',
			11
		)
	);

	$a3=array(
		'z' => array(
			'm' => 'ciao'
		)
	);

	$result=array(
		1,
		'foo' => array(8),
		'bar' => 9,
		'x' => 5,
		'z' => array(
			6,
			'm' => 'ciao',
			11
		),
		7,
		'y' => 10
	);

	$minisuite->expects('array_merge_recursive_unique()')
			  ->that(array_merge_recursive_unique($a1,$a2,$a3))
			  ->equals($result);

});

########################################################### color.php

$minisuite->group('color.php',function() use($minisuite){

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

});

########################################################### system.php

$minisuite->group('system.php',function() use($minisuite){

	$minisuite->expects('human_filesize()')
			  ->that(human_filesize('files/sample.txt'))
			  ->equals('9 b');

	$minisuite->expects('lessdir()')
			  ->that(count(lessdir('.')))
			  ->equals(5);

	$minisuite->group('human_fileperms()',function($minisuite){
		$minisuite->expects('files/')
				  ->that(human_fileperms('files/'))
				  ->equals('drwxrwxrwx');
		$minisuite->expects('files/sample.txt')
				  ->that(human_fileperms('files/sample.txt'))
				  ->equals('-rw-rw-rw-');
	});

	$minisuite->group('mimetype()',function($minisuite){
		$minisuite->expects('files/sample.txt')
				  ->that(mimetype('files/sample.txt'))
				  ->equals('text/plain');
		$minisuite->expects('files/sample.jpg')
				  ->that(mimetype('files/sample.jpg'))
				  ->equals('image/jpeg');
	});

});