<?php

namespace Tests\Service;

use Acme\Skill\Service\ExampleService;

/**
 * Class ExampleServiceTest
 *
 * @author  Alexander Schmidt <a.schmidt@internet-of-voice.de>
 * @license http://opensource.org/licenses/MIT
 */
class ExampleServiceTest extends \PHPUnit_Framework_TestCase {
	/**
	 * testGetCapital
	 */
    public function testGetCapital() {
        $service = new ExampleService();
        $capital = $service->getCapital('en', 'Poland');
        $this->assertEquals('Warsaw', $capital);

        $capital = $service->getCapital('de', 'Polen');
        $this->assertEquals('Warschau', $capital);
    }

	/**
	 * testLowercaseCapital
	 */
	public function testLowercaseCapital() {
		$service = new ExampleService();
		$capital = $service->getCapital('en', 'poland');
		$this->assertEquals('Warsaw', $capital);

		$capital = $service->getCapital('de', 'polen');
		$this->assertEquals('Warschau', $capital);
	}

	/**
	 * testUnknownCountry
	 */
	public function testUnknownCountry() {
		$service = new ExampleService();
		$this->assertFalse($service->getCapital('en', 'The land of milk and honey'));
	}

	/**
	 * testUnsupportedLanguage
	 */
	public function testUnsupportedLanguage() {
		$service = new ExampleService();
		$this->assertFalse($service->getCapital('xy', 'poland'));
	}
}
