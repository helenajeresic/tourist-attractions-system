<?php

use Aws\S3\S3Client;

require 'vendor/autoload.php';

$config = require_once __SITE_PATH . '/app/config.php';

$s3 = new S3Client([
    'version' => '2006-03-01',
    'region' => 'us-east-1',
    'credentials' => [
        'key' => $config['s3']['key'],
        'secret' => $config['s3']['secret']
    ]
]);
?>