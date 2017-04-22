<?php

namespace Tests\Controller;

/**
 * HomeControllerTest
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */
class HomeControllerTest extends AbstractTestCase
{
    /**
     * Test home
     */
    public function testHome() {
        $response = $this->runApp('GET', '/');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Welcome to', (string)$response->getBody());

        $response = $this->runApp('POST', '/');
        $this->assertEquals(405, $response->getStatusCode());

        $response = $this->runApp('GET', '/non-existent-url');
        $this->assertEquals(404, $response->getStatusCode());
    }
}
