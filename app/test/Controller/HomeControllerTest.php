<?php

namespace Tests\Controller;

use \Exception;
use \Slim\Exception\MethodNotAllowedException;
use \Slim\Exception\NotFoundException;

/**
 * Class HomeControllerTest
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 * @license http://opensource.org/licenses/MIT
 */
class HomeControllerTest extends ControllerTestCase {
    /**
     * @throws  Exception
     * @throws  MethodNotAllowedException
     * @throws  NotFoundException
     */
    public function testHome() {
        $response = $this->runApp('GET', '/');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Voice Skill Management System', (string)$response->getBody());

        $response = $this->runApp('POST', '/');
        $this->assertEquals(405, $response->getStatusCode());

        $response = $this->runApp('GET', '/non-existent-url');
        $this->assertEquals(404, $response->getStatusCode());
    }

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testHomeDe() {
		$headers = [
			'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.5,en;q=0.3'
		];

		$response = $this->runApp('GET', '/', $headers);
		$this->assertContains('Ein PHP-Framework zur agilen Entwicklung', (string)$response->getBody());
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testHomeGb() {
		$headers = [
			'HTTP_ACCEPT_LANGUAGE' => 'en-GB;q=0.5,en;q=0.3'
		];

		$response = $this->runApp('GET', '/', $headers);
		$this->assertContains('A PHP based framework aiming at the agile development', (string)$response->getBody());
	}
}
