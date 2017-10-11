<?php

/**
 * Dependency injection
 *
 * @author	Alexander Schmidt <a.schmidt@internet-of-voice.de>
 * @license http://opensource.org/licenses/MIT
 */

$container = $app->getContainer();

// Simple 404 handler
$container['notFoundHandler'] = function(\Slim\Container $c) {
    return function() use ($c) {
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found');
    };
};

// TranslationHelper
$container['translator'] = function(\Slim\Container $c) {
    $settings = $c->get('settings');
    return new \InternetOfVoice\VSMS\Core\Helper\TranslationHelper(
        $settings['locales'],
        $settings['locale_default']
    );
};

// View renderer (Slim)
$container['renderer'] = function(\Slim\Container $c) {
    $settings = $c->get('settings');
    $renderer = new \Slim\Views\Twig($settings['renderer']['template_path'], [
        'cache' => $settings['renderer']['cache_path']
    ]);

    // add Slim's TwigExtension (@see https://github.com/slimphp/Slim-Views)
    $renderer->addExtension(new Slim\Views\TwigExtension($c['router'], $settings['web_root']));

    // make settings array accessible in Twig templates (see src/Template/layout/layout.twig for example usage)
    $renderer->offsetSet('settings', $settings);

    return $renderer;
};

// Logger (Analog) via LogHelper
$container['logger'] = function(\Slim\Container $c) {
    $settings = $c->get('settings');
    $logger   = new InternetOfVoice\VSMS\Core\Helper\LogHelper();
    $logger->format($settings['logger']['format']);
    $logger->setMask($settings['logger']['mask']);
    $logger->handler(Analog\Handler\Threshold::init (
        Analog\Handler\LevelName::init(
            Analog\Handler\File::init($settings['logger']['file'])
        ),
        $settings['logger']['threshold']
    ));

    \Analog\Analog::$timezone = date_default_timezone_get();

    return $logger;
};

// SkillHelper
$container['skillHelper'] = function() {
    return new \InternetOfVoice\VSMS\Core\Helper\SkillHelper();
};
