<?php
error_reporting(E_ALL);
require_once 'credentials.php';
//$url ='https://drupal.hres.ca/md/export';
$url ='https://ims.hres.ca/md/export';
$post_fields = array('data_format'=>'json', 'name'=>$mdName, 'password'=>$mdPassword);
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_TIMEOUT, 0);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 100);
$curl_response = curl_exec($curl);
curl_close($curl);
$directoryName = dirname(__FILE__).'/upload/';
//var_dump($curl_response);
if ($curl_response) {
  $fileName = 'md_api'.date('m-d-Y_hia').'.json';
  if (!file_exists($directoryName.$fileName)) {
    file_put_contents($directoryName.$fileName, $curl_response);
  }
}
?>
