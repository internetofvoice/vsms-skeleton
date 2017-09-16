<?php

/**
 * Bootstrap
 *
 * @author	Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */

$appDir = __DIR__ . '/app';

require $appDir . '/vendor/autoload.php';
$settings  = require $appDir . '/config/settings.php';
$container = new \Slim\Container($settings);
$app       = new \Slim\App($container);

require $appDir . '/config/dependencies.php';
require $appDir . '/config/routing.php';

$app->run();
