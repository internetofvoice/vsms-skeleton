<?php

namespace Tests\Controller;

use \Exception;
use \PHPUnit\Framework\TestCase;
use \Psr\Http\Message\ResponseInterface;
use \Slim\App;
use \Slim\Exception\MethodNotAllowedException;
use \Slim\Exception\NotFoundException;
use \Slim\Http\Environment;
use \Slim\Http\Headers;
use \Slim\Http\Request;
use \Slim\Http\RequestBody;
use \Slim\Http\Response;
use \Slim\Http\Uri;

/**
 * Class ControllerTestCase
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 * @license http://opensource.org/licenses/MIT
 */
abstract class ControllerTestCase extends TestCase {
    /**
     * Run the application
     *
     * @param  string               $method     Request method
     * @param  string               $uri        Request URI
     * @param  array|null           $headers    additional HTTP headers
     * @param  array|object|null    $data       Request data
     * @return ResponseInterface
     * @throws Exception
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     */
    public function runApp($method, $uri, $headers = [], $data = null) {
        $headers = array_merge([
            'REQUEST_METHOD'             => $method,
            'REQUEST_URI'                => $uri,
            'CONTENT_TYPE'               => 'application/json',
            'HTTP_SIGNATURE'             => '',
            'HTTP_SIGNATURECERTCHAINURL' => '',
        ], $headers);

        // Fake $_SERVER array as expected by vendor library
        $_SERVER['HTTP_SIGNATURE']             = $headers['HTTP_SIGNATURE'];
        $_SERVER['HTTP_SIGNATURECERTCHAINURL'] = $headers['HTTP_SIGNATURECERTCHAINURL'];

        // Create prerequisites
        $environment     = Environment::mock($headers);
        $request_uri     = Uri::createFromString('http://example.com' . $uri); // ignore example.com, just create URI
        $request_headers = Headers::createFromEnvironment($environment);
        $cookies         = [];
        $serverParams    = $environment->all();

        // Create body, optional with request data
        $body = new RequestBody();
        if(isset($data)) {
            $body->write($data);
            $body->rewind();
        }

        $request   = new Request($method, $request_uri, $request_headers, $cookies, $serverParams, $body);
        $settings  = require __DIR__ . '/../../config/settings.php';
        $app       = new App($settings);
        $container = $app->getContainer();
        $container['request'] = $request; // override with mocked request

        require __DIR__ . '/../../config/dependencies.php';
        require __DIR__ . '/../../config/routing.php';

        return $app->process($request, new Response());
    }
}
