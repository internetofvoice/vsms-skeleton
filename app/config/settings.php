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

// Environment dependent overrides
switch($environment) {
    case 'dev':
        $displayErrorDetails = true;
        $validateCertificate = false;
    break;

    case 'test':
        $displayErrorDetails = true;
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

        'locale_default' => 'en-US',
        'locales'        => ['de-DE', 'en-US', 'en-GB'],
    ],
];
