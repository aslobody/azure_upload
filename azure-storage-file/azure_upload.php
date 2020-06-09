<?php
/**
 * Azure file storage upload
 */
require_once 'vendor/autoload.php';
require_once '../credentials.php';

use MicrosoftAzure\Storage\File\FileRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

$connectionString = 'DefaultEndpointsProtocol=https;AccountName=$accountName;AccountKey=$accountKey';
$fileClient = FileRestProxy::createFileService($connectionString);

// Azure share folder
$shareName = "dhpid";

// local file
// path to directory
$uploadDir = '/var/www/html/upload';

// select the newest file
$files = scandir($uploadDir, SCANDIR_SORT_DESCENDING);
$fileToUpload = $files[0];

$content = file_get_contents($fileToUpload);

// upload file
try {
  $fileClient->createFileFromContent($shareName, $filename, $content, null);
}
catch(ServiceException $e){
    $code = $e->getCode();
    $error_message = $e->getMessage();
    //file_put_contents("error_log.txt",$code.": ".$error_message,FILE_APPEND);
    echo $error_message;
}
catch(InvalidArgumentTypeException $e){
    $code = $e->getCode();
    $error_message = $e->getMessage();
    //file_put_contents("error_log.txt",$code.": ".$error_message,FILE_APPEND);
    echo $error_message;
}

?>
