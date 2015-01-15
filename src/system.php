<?php

/*
	Get human-readable file size
	
	Parameters
		string $path
	
	Return
		string
*/
function human_filesize($path){
	$bytes=filesize($path);
	$units=array('b','Kb','Mb','Gb','Tb','Eb');
	for($i=count($units)-1;$i>=0;--$i){
		if($bytes>=pow(1024,$i)){
			return str_replace('.',',',(string)round($bytes/pow(1024,$i),2).' '.$units[$i]);
		}
	}
	return false;
}

/*
	Scan a directory without '.' and '..'

	Parameters
		string $dir

	Return
		array
*/
function lessdir($dir){
	return array_slice(scandir($dir),2);
}