<?php
//to autoload all files because PHP is old

$dir = __DIR__ . '/Classes';
$files = scandir($dir, SCANDIR_SORT_ASCENDING);
unset($files[0]);
unset($files[1]);

foreach ($files as $file) {
    include (__DIR__ . '/Classes/' . $file);
}

$dir = __DIR__ . '/Models';
$files = scandir($dir, SCANDIR_SORT_ASCENDING);
unset($files[0]);
unset($files[1]);

foreach ($files as $file) {
    include (__DIR__ . '/Models/' . $file);
}