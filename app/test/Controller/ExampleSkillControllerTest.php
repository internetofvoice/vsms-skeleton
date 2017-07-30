<?php

namespace Tests\Controller;

/**
 * ExampleSkillControllerTest
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */
class ExampleSkillControllerTest extends ControllerTestCase
{
	/**
	 * testLaunchRequest
	 */
	public function testLaunchRequest() {
        $fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
        $header   = $fixture['header'];
        $body     = json_encode($fixture['body-launch']);
		$response = $this->runApp('POST', '/skill/example', $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertContains('Welcome to', $json_body['response']['outputSpeech']['text']);
	}

	/**
	 * testHelpIntent
	 */
	public function testHelpIntent() {
        $fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
        $header   = $fixture['header'];
        $body     = json_encode($fixture['body-help']);
		$response = $this->runApp('POST', '/skill/example', $header, $body);
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
	 * testStopIntent
	 */
	public function testStopIntent() {
        $fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
        $header   = $fixture['header'];
        $body     = json_encode($fixture['body-stop']);
		$response = $this->runApp('POST', '/skill/example', $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertContains('Good bye', $json_body['response']['outputSpeech']['text']);
	}

	/**
	 * testCapitalIntent
	 */
	public function testCapitalIntent() {
        $fixture  = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleRequest.json'), true);
        $header   = $fixture['header'];
        $body     = json_encode($fixture['body-capital']);
		$response = $this->runApp('POST', '/skill/example', $header, $body);
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('"outputSpeech"', strval($response->getBody()));

		$json_body = json_decode(strval($response->getBody()), true);
		$this->assertArrayHasKey('response', $json_body);
		$this->assertArrayHasKey('outputSpeech', $json_body['response']);
		$this->assertArrayHasKey('text', $json_body['response']['outputSpeech']);
		$this->assertRegExp(
			'~The capital of|I did not unterstand the country|Please link this skill~',
			$json_body['response']['outputSpeech']['text']
		);
	}
}
