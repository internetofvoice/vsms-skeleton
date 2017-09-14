<?php

namespace Tests\Service;

use Acme\Skill\Service\ExampleService;

/**
 * ExampleServiceTest
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 */

class ExampleServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCapital() {
        $service = new ExampleService();
        $capital = $service->getCapital('en', 'Poland');
        $this->assertEquals('Warsaw', $capital);

        $capital = $service->getCapital('de', 'Polen');
        $this->assertEquals('Warschau', $capital);

        $capital = $service->getCapital('de', 'Deutschland');
        $this->assertNotEquals('Moskau', $capital);
    }
}
