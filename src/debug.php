<?php

/*
	Tiny debugging function

	Previous author
		Zend

	Parameters
		mixed $var

	Return
		mixed
*/
function debug($var){
	// Bufferize the output
	ob_start();
	var_dump($var);
	$output=ob_get_clean();
	// Neaten the newlines and indents
	$output=preg_replace("/\]\=\>\n(\s+)/m", "] => ",$output);
	// Write the output
	if(php_sapi_name()=='cli'){
		$output=PHP_EOL.$output.PHP_EOL;
	}
	else{
		if(!extension_loaded('xdebug')){
			$output=htmlspecialchars($output,ENT_QUOTES);
		}
		$output='<pre>'.$output.'</pre>';
	}
	echo $output;
	return $var;
}
