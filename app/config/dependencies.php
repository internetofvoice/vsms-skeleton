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

// Translations
$container['i18n'] = function(\Slim\Container $c) {
    $settings = $c->get('settings');
    return new \InternetOfVoice\VSMS\Core\Helper\TranslationHelper(
        $settings['locales'],
        $settings['locale_default']
    );
};

// View renderer
$container['renderer'] = function (\Slim\Container $c) {
    $settings = $c->get('settings');
    $renderer = new \Slim\Views\Twig($settings['renderer']['template_path'], [
        'cache' => $settings['renderer']['cache_path']
    ]);

    $renderer->addExtension(new Slim\Views\TwigExtension($c['router'], $settings['web_root']));
    $renderer->offsetSet('settings', $settings);
    return $renderer;
};
