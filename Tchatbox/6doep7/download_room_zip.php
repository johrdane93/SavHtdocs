<?php
$lines = file_get_contents("tchatbox.php");
$lines = str_replace('$pwd = encrypt_decrypt(\'decrypt\',$jfo[0]->pwd);', '', $lines);
file_put_contents("tchat.php", $lines);

$rootPath = realpath(getcwd());

$zip = new ZipArchive();
$zip->open('chat.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file){
    if (!$file->isDir() && $file->getFilename() != "index.php" && $file->getFilename() != "chat.csv" && $file->getFilename() != "chat.html" && $file->getFilename() != "chat.zip" && $file->getFilename() != "last_activity.ini" && $file->getFilename() != "tchatbox.php"){
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);
        $zip->addFile($filePath, $relativePath);
    }
}

$zip->close();

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename("chat.zip") . "\""); 
readfile("chat.zip");

if(file_exists("tchat.php")){
	unlink("tchat.php");
}
if(file_exists("chat.zip")){
	unlink("chat.zip");
}
?>