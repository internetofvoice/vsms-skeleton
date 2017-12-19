<?php

namespace Tests\Controller;

use \Exception;
use \Slim\Exception\MethodNotAllowedException;
use \Slim\Exception\NotFoundException;

/**
 * Class ExampleSkillControllerTest
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 * @license http://opensource.org/licenses/MIT
 */
class ExampleSkillControllerTest extends ControllerTestCase {
	const SKILL_BASE_URL = '/example/skill';

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testLaunchRequest() {
        $fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
        $header   = $fixture['header'];
        $body     = json_encode($fixture['body-launch']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertContains('Welcome to', $json_body['response']['outputSpeech']['text']);
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testLaunchRequestGb() {
		$fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
		$header   = $fixture['header'];
		$fixture['body-launch']['request']['locale'] = 'en-GB';
		$body     = json_encode($fixture['body-launch']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertContains('Welcome to', $json_body['response']['outputSpeech']['text']);
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testStartOverIntent() {
		$fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
		$header   = $fixture['header'];
		$body     = json_encode($fixture['body-start-over']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertContains('Welcome to', $json_body['response']['outputSpeech']['text']);
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testSessionEnded() {
		$fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
		$header   = $fixture['header'];
		$body     = json_encode($fixture['body-session-ended']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertNotContains('"outputSpeech"', strval($response->getBody()));
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testHelpIntent() {
        $fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
        $header   = $fixture['header'];
        $body     = json_encode($fixture['body-help']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertContains('To find out the capital of a country', $json_body['response']['outputSpeech']['text']);

		$this->assertArrayHasKey('card', $json_body['response']);
		$this->assertArrayHasKey('type', $json_body['response']['card']);
		$this->assertArrayHasKey('title', $json_body['response']['card']);
		$this->assertEquals('Simple', $json_body['response']['card']['type']);
		$this->assertEquals('Help', $json_body['response']['card']['title']);
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testStopIntent() {
        $fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
        $header   = $fixture['header'];
        $body     = json_encode($fixture['body-stop']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertContains('Good bye', $json_body['response']['outputSpeech']['text']);
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testCancelIntent() {
		$fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
		$header   = $fixture['header'];
		$body     = json_encode($fixture['body-cancel']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertContains('Good bye', $json_body['response']['outputSpeech']['text']);
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testCapitalIntentLink() {
        $fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
        $header   = $fixture['header'];
        $body     = json_encode($fixture['body-capital']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertContains('Please link this skill', $json_body['response']['outputSpeech']['text']);
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testCapitalIntentLinked() {
		$fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
		$header   = $fixture['header'];

		$fixture['body-capital']['session']['user']['accessToken'] = 'TOKEN';
		$body     = json_encode($fixture['body-capital']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('ssml', $json_body['response']['outputSpeech']);
		$this->assertContains('The capital of France is Paris', $json_body['response']['outputSpeech']['ssml']);
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testCapitalIntentSession() {
		$fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
		$header   = $fixture['header'];

		$fixture['body-capital']['session']['user']['accessToken'] = 'TOKEN';
		$fixture['body-capital']['session']['new'] = false;
		$body     = json_encode($fixture['body-capital']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('ssml', $json_body['response']['outputSpeech']);
		$this->assertContains('The capital of France is Paris', $json_body['response']['outputSpeech']['ssml']);
		$this->assertContains('Please ask another question or say stop', $json_body['response']['outputSpeech']['ssml']);
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testCapitalIntentNoSlot() {
		$fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
		$header   = $fixture['header'];

		unset($fixture['body-capital']['request']['intent']['slots']['country']);
		$body     = json_encode($fixture['body-capital']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertContains('Sorry, I did not understand the country', $json_body['response']['outputSpeech']['text']);
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testCapitalIntentUnknownCountry() {
		$fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
		$header   = $fixture['header'];

		$fixture['body-capital']['session']['user']['accessToken'] = 'TOKEN';
		$fixture['body-capital']['request']['intent']['slots']['country']['value'] = 'Land of milk and honey';
		$body     = json_encode($fixture['body-capital']);
		$response = $this->runApp('POST', self::SKILL_BASE_URL, $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertContains('Sorry, I did not understand the country', $json_body['response']['outputSpeech']['text']);
	}

	/**
	 * @throws  Exception
	 * @throws  MethodNotAllowedException
	 * @throws  NotFoundException
	 */
	public function testBadRequest() {
		$response = $this->runApp('POST', self::SKILL_BASE_URL, [], '');
		$this->assertEquals(400, $response->getStatusCode());
	}
}
