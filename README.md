Installation
=====================================================
## Download a copy of the application to server
```sh
git clone https://github.com/aslobody/azure_upload.git
```
## Create upload folder and set the permission
```sh
mkdir upload
chmod -R 777 /path/to/upload
```

## Update path to directory in azure_upload.php file

$uploadDir = '/var/www/html/upload';

and

require_once '/var/www/html/credentials.php';

## Set the cron job to download JSON file from MD API every day at 8am

0 8 * * * php /var/www/html/md.php

## Set the cron job to upload files to Azure blob every day at 8:30am

*/30 8 * * * php /var/www/html/azure-storage-file/azure_upload.php
