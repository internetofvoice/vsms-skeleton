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
$logFormat           = '%2$s %3$s: %4$s' . PHP_EOL; // Including remote IP: '%s %s %s: %s' . PHP_EOL
$logMask             = [                            // Mask values of these keys in log
    'username',
    'password',
    'accessToken',
];

// Environment dependent overrides
switch($environment) {
    case 'dev':
        $displayErrorDetails = true;
        $validateCertificate = false;
        $enableRenderCache   = false;
        $logLevel            = \Analog::DEBUG;
        $logMask             = [];
    break;

    case 'test':
        $displayErrorDetails = true;
        $logLevel            = \Analog::DEBUG;
    break;

    case 'stage':
        $displayErrorDetails = true;
        $logLevel            = \Analog::DEBUG;
    break;

    case 'prod':
        $logLevel            = \Analog::DEBUG;
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
        'auto_init'              => ['logger', 'translator', 'skillHelper'],

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
            'format'    => $logFormat,
            'mask'      => $logMask,
        ],
    ],
];
