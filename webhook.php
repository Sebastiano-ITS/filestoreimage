<?php
$versionFile = __DIR__ . '/version.txt';

$version = (int) file_get_contents($versionFile);
$version++;

file_put_contents($versionFile, $version);

http_response_code(200);
