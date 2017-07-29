<?php

/**
 * Routing configuration
 *
 * @author	Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */

/* Skills */
$app->post('/skill/example', \Acme\Skill\Controller\ExampleSkillController::class);
// @TODO
//$app->any('/link-account/example', \Acme\Skill\Controller\ExampleLinkController::class);
//$app->get('/privacy/example', \Acme\Skill\Controller\ExampleLinkController::class . ':privacy');

/* Home */
$app->get('/', \Acme\Skill\Controller\HomeController::class . ':home');
