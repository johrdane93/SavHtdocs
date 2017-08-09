<?php 
// copy a folder recursively
function recurse_copy($src,$dst) { 
    $dir = opendir($src);
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file);
            } 
        } 
    } 
    closedir($dir); 
}

// encrypt / decrypt a string
function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

// scan subfolders of a directory
function Scan($dir,$limit) {
	$subdir = scandir($dir);
	$result = array();
	$last_activity = "";
	foreach($subdir as $key => $value){
			if(is_dir("../".$value) && $value != "." && $value != ".." && $value != "classes" && $value != "css" && $value != "js" && $value != "tchatbox" && $value != "tools" && $value != "images"){
				$temp = scandir("../".$value);
				foreach($temp as $key2 => $value2){
					$extension = pathinfo($value2, PATHINFO_EXTENSION);
					if($extension == "ini"){
						$last_activity = $value."/".$value2;
						$content = file_get_contents("../".$last_activity);
						$last_message_posted = time() - $content;
						if($content != "" && $last_message_posted > 3600*$limit){
							rrmdir("../".$value);
						}
					}
				}
				array_push($result, $content);
			}
		}
	return $result;
}

// Remove folder and its content
function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }
 
function getLastMessages() {
	if(file_exists('chat.txt')){
        $lines = file('chat.txt');
		if(count($lines) > 10000){
			file_put_contents('chat.txt', "<span class='pseudo' style=\"color:#3b88eb;\">init</span><span>init</span><span class='time'>00:00</span>\r\n");
		}
		$text = array();
		foreach($lines as $line){
			array_push($text,$line);
		}
		return $text;
     }
}
?>