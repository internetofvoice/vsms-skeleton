<?php

namespace Tests\Controller;

/**
 * Class ExampleLinkControllerTest
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 * @license http://opensource.org/licenses/MIT
 */
class ExampleLinkControllerTest extends ControllerTestCase {
	const LINK_BASE_URL = '/example/link';
	const PRIV_BASE_URL = '/example/privacy';

	/**
	 * testInvocation
	 */
    public function testInvocation() {
        $fixture = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleLink.json'), true);
        $headers = [
            'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.5,en;q=0.3'
        ];

        $url = self::LINK_BASE_URL . '?' . http_build_query($fixture['invocation']);

        $response = $this->runApp('GET', $url, $headers);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('input type="hidden" name="redirect_uri"', (string)$response->getBody());
    }

	/**
	 * testInvalidInvocation
	 */
	public function testInvalidInvocation() {
		$fixture = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleLink.json'), true);
		$headers = [
			'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.5,en;q=0.3'
		];

		unset($fixture['invocation']['client_id']);
		$url = self::LINK_BASE_URL . '?' . http_build_query($fixture['invocation']);

		$response = $this->runApp('GET', $url, $headers);
		$this->assertEquals(404, $response->getStatusCode());
		$this->assertContains('Page not found', (string)$response->getBody());
	}

	/**
     * testSubmission
     */
    public function testSubmission() {
        $fixture = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleLink.json'), true);
        $headers = [
            'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.5,en;q=0.3'
        ];

        $response = $this->runApp('POST', self::LINK_BASE_URL, $headers, json_encode($fixture['submission']));
        $temp     = $response->getHeader('Location');
        $location = count($temp) ? array_shift($temp) : false;

        $this->assertEquals(303, $response->getStatusCode());
        $this->assertContains('&access_token=', $location);
        $this->assertContains('&token_type=Bearer', $location);
    }

	/**
	 * testWrongPassword
	 */
	public function testWrongPassword() {
		$fixture = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleLink.json'), true);
		$fixture['submission']['password'] = 'WRONG_PASSWORD';
		$headers = [
			'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.5,en;q=0.3'
		];

		$response = $this->runApp('POST', self::LINK_BASE_URL, $headers, json_encode($fixture['submission']));
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('input type="hidden" name="redirect_uri"', (string)$response->getBody());
	}

	/**
	 * testEmptyPassword
	 */
	public function testEmptyPassword() {
		$fixture = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleLink.json'), true);
		$fixture['submission']['password'] = '';
		$headers = [
			'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.5,en;q=0.3'
		];

		$response = $this->runApp('POST', self::LINK_BASE_URL, $headers, json_encode($fixture['submission']));
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('input type="hidden" name="redirect_uri"', (string)$response->getBody());
	}

	/**
     * testPrivacy
     */
    public function testPrivacy() {
        $headers = [
            'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.5,en;q=0.3'
        ];

        $response = $this->runApp('GET', self::PRIV_BASE_URL, $headers);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hauptstadt-Skill', (string)$response->getBody());
    }
}
