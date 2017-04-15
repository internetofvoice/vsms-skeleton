<?php

/**
 * Routing configuration
 *
 * @author	Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */

/* Home */
$app->get('/', \Acme\VSMS\Controller\HomeController::class . ':home');
