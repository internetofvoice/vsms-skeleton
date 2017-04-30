<?php

/**
 * App configuration
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */

// Global settings template
$environment         = getenv('APP_ENV') ?: 'prod'; // Get environment from APP_ENV (web server or command shell)
$base_dir            = realpath(__DIR__ . '/..');   // File system root
$web_root            = '';                          // Web server root
$displayErrorDetails = false;                       // Display error details?
$validateCertificate = true;                        // Validate request certificate (i.e. Amazon Signature Chain)?
$enableRenderCache   = true;                        // Enable renderer caching?
$logLevel            = \Analog::NOTICE;             // Log level (URGENT, ALERT, CRITICAL , ERROR, WARNING, NOTICE, INFO, DEBUG)

// Environment dependent overrides
switch($environment) {
    case 'dev':
        $displayErrorDetails = true;
        $validateCertificate = false;
        $enableRenderCache   = false;
        $logLevel            = \Analog::DEBUG;
    break;

    case 'test':
        $displayErrorDetails = true;
        $logLevel            = \Analog::DEBUG;
    break;

    case 'stage':
        $displayErrorDetails = true;
    break;

    case 'prod':
    break;

    default:
        throw new InvalidArgumentException('Unknown environment "' . $environment . '"');
    break;
}

return [
    'settings' => [
        'environment'            => $environment,
        'displayErrorDetails'    => $displayErrorDetails,
        'validateCertificate'    => $validateCertificate,
        'addContentLengthHeader' => false,

        'base_dir'   => $base_dir,
        'asset_dir'  => realpath($base_dir . '/../asset'),
        'web_root'   => $web_root,
        'asset_root' => $web_root . '/asset',

        'locale_default'   => 'en-US',
        'locales'          => ['de-DE', 'en-US', 'en-GB'],
        'translation_path' => $base_dir . '/src/Translation',

        'renderer' => [
            'template_path' => [$base_dir . '/src/Template'],
            'cache_path'    => ($enableRenderCache ? $base_dir . '/var/rendered' : false),
        ],

        'logger' => [
            'file'      => $base_dir . '/var/log/app.log',
            'threshold' => $logLevel,
            'mask'      => ['username', 'password', 'accessToken'],
        ],
    ],
];
