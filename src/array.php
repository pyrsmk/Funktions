<?php

/*
	Merge arrays recursively
	
	Previous authors
		walf (http://php.net/manual/en/function.array-merge-recursive.php#104145)
		gabriel.sobrinho@gmail.com
		daniel@danielsmedegaardbuus.dk

	Parameters
		array $array    : the first array to merge
		array $array2   : the second array to merge
		...

	Return
		array
*/
function array_merge_recursive_unique() {
	// Get arrays
	if(func_num_args() < 2) {
		throw new Exception(__FUNCTION__.' needs two or more array arguments');
		return;
	}
	$arrays = func_get_args();
	// Merge arrays
	$merged = [];
	while($arrays) {
		$array = array_shift($arrays);
		if(!is_array($array)) {
			throw new Exception(__FUNCTION__.' has encountered a non array argument');
			return;
		}
		// Merge an array
		foreach($array as $key => $value){
			if(is_string($key)) {
				if(is_array($value) && array_key_exists($key, $merged) && is_array($merged[$key])) {
					$merged[$key] = call_user_func(__FUNCTION__, $merged[$key], $value);
				}
				else {
					$merged[$key] = $value;
				}
			}
			else{
				$merged[] = $value;
			}
		}
	}
	return $merged;
}
