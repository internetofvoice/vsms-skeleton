<?php

namespace Tests\Controller;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

/**
 * AbstractTestCase
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */

abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Run the application
     *
     * @param  string               $method     Request method
     * @param  string               $uri        Request URI
     * @param  array|null           $headers    additional HTTP headers
     * @param  array|object|null    $data       Request data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function runApp($method, $uri, $headers = [], $data = null) {
        $headers = array_merge([
            'REQUEST_METHOD' => $method,
            'REQUEST_URI'    => $uri
        ], $headers);

        $environment = Environment::mock($headers);
        $request = Request::createFromEnvironment($environment);
        if (isset($data)) {
            $request = $request->withParsedBody($data);
        }

        $settings = require __DIR__ . '/../../config/settings.php';
        $app = new App($settings);
        $container = $app->getContainer();
        $container['request'] = $request; // override with mocked request

        require __DIR__ . '/../../config/dependencies.php';
        require __DIR__ . '/../../config/routing.php';

        return $app->process($request, new Response());
    }
}
