<?php
/**
 * Azure file storage upload
 */
require_once 'vendor/autoload.php';
require_once '/var/www/html/credentials.php';

use MicrosoftAzure\Storage\File\FileRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Common\ServicesBuilder;

$connectionString = 'DefaultEndpointsProtocol=https;AccountName='.$accountName.';AccountKey='.$accountKey;
$fileClient = FileRestProxy::createFileService($connectionString);

// Azure share folder
$shareName = "dhpid/DRUPAL";

// local file
// path to directory
$uploadDir = '/var/www/html/upload';

// select the newest file
$files = scandir($uploadDir, SCANDIR_SORT_DESCENDING);
$fileToUpload = $files[0];

$file = $uploadDir.'/'.$fileToUpload;
$content = fopen($file, "r");

//$content = file_get_contents($uploadDir.'/'.$fileToUpload);

// upload file
try {
  $fileClient->createFileFromContent($shareName, $fileToUpload, $content);
}
catch(ServiceException $e){
    $code = $e->getCode();
    $error_message = date('m-d-Y_hia').': '.$e->getMessage();
    file_put_contents("error_log.txt",$code.": ".$error_message,FILE_APPEND);
    //echo $error_message;
}
catch(InvalidArgumentTypeException $e){
    $code = $e->getCode();
    $error_message = date('m-d-Y_hia').': '.$e->getMessage();
    file_put_contents("error_log.txt",$code.": ".$error_message,FILE_APPEND);
    //echo $error_message;
}

?>
