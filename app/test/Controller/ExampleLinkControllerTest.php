<?php

namespace Tests\Controller;

/**
 * ExampleLinkControllerTest
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */

class ExampleLinkControllerTest extends ControllerTestCase
{
	/**
	 * testInvocation
	 */
    public function testInvocation() {
        $fixture = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleLink.json'), true);
        $headers = [
            'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.5,en;q=0.3'
        ];

        $url = '/example/link?' . http_build_query($fixture['invocation']);

        $response = $this->runApp('GET', $url, $headers);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('input type="hidden" name="redirect_uri"', (string)$response->getBody());
    }

    /**
     * testSubmission
     */
    public function testSubmission() {
        $fixture = json_decode(file_get_contents(__DIR__ . '/../Fixtures/ExampleLink.json'), true);
        $headers = [
            'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.5,en;q=0.3'
        ];

        $response = $this->runApp('POST', '/example/link', $headers, json_encode($fixture['submission']));
        $temp     = $response->getHeader('Location');
        $location = count($temp) ? array_shift($temp) : false;

        $this->assertEquals(303, $response->getStatusCode());
        $this->assertContains('&access_token=', $location);
        $this->assertContains('&token_type=Bearer', $location);
    }

    /**
     * testPrivacy
     */
    public function testPrivacy() {
        $headers = [
            'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.5,en;q=0.3'
        ];

        $response = $this->runApp('GET', '/example/privacy', $headers);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hauptstadt-Skill', (string)$response->getBody());
    }
}