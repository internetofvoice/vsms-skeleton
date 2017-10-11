<?php

/**
 * Routing configuration
 *
 * @author	Alexander Schmidt <a.schmidt@internet-of-voice.de>
 * @license http://opensource.org/licenses/MIT
 */

/* Skills */
$app->post('/example/skill', \Acme\Skill\Controller\ExampleSkillController::class);
$app->any('/example/link', \Acme\Skill\Controller\ExampleLinkController::class);
$app->get('/example/privacy', \Acme\Skill\Controller\ExampleLinkController::class . ':privacy');

/* Home */
$app->get('/', \Acme\Skill\Controller\HomeController::class . ':home');
