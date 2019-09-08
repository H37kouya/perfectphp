<?php

require __DIR__ . '/../vendor/autoload.php';

require '../bootstrap.php';
// require '../MiniBlogApplication.php';

$app = new \App\MiniBlogApplication(true);
$app->run();
