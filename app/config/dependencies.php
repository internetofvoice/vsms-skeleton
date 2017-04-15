<?php

/**
 * Dependency injection
 *
 * @author	Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */

$container = $app->getContainer();

// 404 Handler
$container['notFoundHandler'] = function(\Slim\Container $c) {
    return function() use ($c) {
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found');
    };
};
