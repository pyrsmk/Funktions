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

$minisuite=new MiniSuite\Cli('Funktions');
$minisuite->disableAnsiColors();

########################################################### array.php

$minisuite->group('array.php',function() use($minisuite){

	$minisuite->test('array_merge_recursive_unique()',function(){
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
		return array_merge_recursive_unique($a1,$a2,$a3)==$result;
	});

});

########################################################### color.php

$minisuite->group('color.php',function() use($minisuite){

	$minisuite->test('rgb2hsl()',function(){
		return rgb2hsl(188,58,58)==array(0,53,48);
	});

	$minisuite->test('hsl2rgb()',function(){
		return hsl2rgb(0,53,48)==array(187,58,58);
	});

	$minisuite->test('rgb2hsv()',function(){
		return rgb2hsv(188,58,58)==array(0,69,74);
	});

	$minisuite->test('hsv2rgb()',function(){
		return hsv2rgb(0,69,74)==array(188,58,58);
	});

	$minisuite->test('rgb2html()',function(){
		return rgb2html(188,58,58)=='#bc3a3a';
	});

	$minisuite->test('html2rgb()',function(){
		return html2rgb('#bc3a3a')==array(188,58,58);
	});

});

########################################################### system.php

$minisuite->group('color.php',function() use($minisuite){

	$minisuite->test('human_filesize()',function(){
		return human_filesize('sample.txt')=='9 b';
	});

	$minisuite->test('lessdir()',function(){
		return count(lessdir('..')==2);
	});

});

########################################################### Run tests

$minisuite->run();