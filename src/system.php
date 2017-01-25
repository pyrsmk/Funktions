<?php

/*
	Tiny debugging function

	Parameters
		mixed $var

	Return
		mixed
*/
function debug($var) {
	// Bufferize the output
	ob_start();
	var_dump($var);
	$output = ob_get_clean();
	// Neaten the newlines and indents
	$output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
	// Write the output
	if(php_sapi_name() == 'cli'){
		$output = PHP_EOL.$output.PHP_EOL;
	}
	else{
		$output = '<pre>'.htmlspecialchars($output).'</pre>';
	}
	echo $output;
	return $var;
}

/*
	Get local/remote image size

	Parameters
		string $path

	Return
		array
*/
function getimagesizefast($path) {
    if(filter_var($path, FILTER_VALIDATE_URL)) {
        $request = curl_init($path);
        curl_setopt($request, CURLOPT_HTTPHEADER, ['Range: bytes=0-32768']);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($request);
        curl_close($request);
        $image = @imagecreatefromstring($data);
        // GIF, JPEG
        if($image !== false) {
            $width = imagesx($image);
            $height = imagesy($image);
        }
        // PNG
        else {
            // Inspired from : https://github.com/tommoor/fastimage/blob/master/Fastimage.php
            list(, $width, $height) = unpack('N*', substr($data, 16, 8));
        }
    }
    else {
        list($width, $height) = getimagesize($path);
    }
    return [
        'width' => $width,
        'height' => $height
    ];
}

/*
	Get human-readable file size
	
	Parameters
		string $path
	
	Return
		string
*/
function human_filesize($path) {
	$bytes = filesize($path);
	$units = ['b', 'Kb', 'Mb', 'Gb', 'Tb', 'Eb'];
	for($i=count($units)-1; $i>=0; --$i) {
		if($bytes >= pow(1024, $i)) {
			return str_replace('.', ',', (string)round($bytes / pow(1024, $i), 2).' '.$units[$i]);
		}
	}
	return false;
}

/*
	Get human-readable permissions

	Parameters
		string $path

	Return
		string
*/
function human_fileperms($path) {
	$perms = fileperms($path);
	// Socket
	if(($perms & 0xC000) == 0xC000){
		$info = 's';
	}
	// Symbolic Link
	elseif(($perms & 0xA000) == 0xA000){
		$info = 'l';
	}
	// Regular
	elseif(($perms & 0x8000) == 0x8000){
		$info = '-';
	}
	// Block special
	elseif(($perms & 0x6000) == 0x6000){
		$info = 'b';
	}
	// Directory
	elseif(($perms & 0x4000) == 0x4000){
		$info = 'd';
	}
	// Character special
	elseif(($perms & 0x2000) == 0x2000){
		$info = 'c';
	}
	// FIFO pipe
	elseif(($perms & 0x1000) == 0x1000){
		$info = 'p';
	}
	// Unknown
	else{
		$info = 'u';
	}
	// Owner
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
        (($perms & 0x0800) ? 's' : 'x'):
        (($perms & 0x0800) ? 'S' : '-'));
	// Group
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
        (($perms & 0x0400) ? 's' : 'x'):
        (($perms & 0x0400) ? 'S' : '-'));
	// World
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
        (($perms & 0x0200) ? 't' : 'x'):
        (($perms & 0x0200) ? 'T' : '-'));
	return $info;
}

/*
	Scan a directory without '.' and '..'

	Parameters
		string $dir

	Return
		array
*/
function lessdir($dir) {
	if(!file_exists($dir)) {
		return [];
	}
	else {
		return array_slice(scandir($dir), 2);
	}
}

/*
	Get a file's mime type

	Parameters
		string $path

	Return
		string
*/
function mimetype($path) {
    if(filter_var($path, FILTER_VALIDATE_URL)) {
        $request = curl_init($path);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_NOBODY, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($request);
        $type = curl_getinfo($request, CURLINFO_CONTENT_TYPE);
        curl_close($request);
    }
    else {
        if(!is_file($path)) {
            throw new Exception("'$path' is not a file");
        }
        if(!is_readable($path)) {
            throw new Exception("'$path' is not readable");
        }
        $finfo = finfo_open(FILEINFO_MIME);
        $type = finfo_file($finfo,$path);
        finfo_close($finfo);
        if(empty($type)) {
            throw new Exception("Cannot retrieve mime type with fileinfo extension");
        }
    }
	if(!$type) {
		return 'application/octet-stream';
	}
	else {
		$type = explode(';', $type);
		return $type[0];
	}
}

/*
	Remove a directory recursively

	Parameters
		string $path
*/
function rrmdir($path) {
	if(is_dir($path)) {
		foreach(lessdir($path) as $file) {
			if(is_dir("$path/$file")) {
				rrmdir("$path/$file");
			}
			else {
				unlink("$path/$file");
			}
		}
		rmdir($path);
	}
}
