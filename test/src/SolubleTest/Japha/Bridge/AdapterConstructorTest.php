<?php

/*
 * Soluble Japha
 *
 * @link      https://github.com/belgattitude/soluble-japha
 * @copyright Copyright (c) 2013-2017 Vanvelthem Sébastien
 * @license   MIT License https://github.com/belgattitude/soluble-japha/blob/master/LICENSE.md
 */

namespace SolubleTest\Japha\Bridge;

use Soluble\Japha\Bridge\Adapter;
use Soluble\Japha\Bridge\Driver\Pjb62\Pjb62Driver;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-11-04 at 16:47:42.
 */
class AdapterConstructorTest extends TestCase
{
    /**
     * @var string
     */
    protected $servlet_address;

    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        \SolubleTestFactories::startJavaBridgeServer();
        $this->servlet_address = \SolubleTestFactories::getJavaBridgeServerAddress();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testConstructorThrowsUnsupportedDriverException()
    {
        $this->expectException('Soluble\Japha\Bridge\Exception\UnsupportedDriverException');
        $ba = new Adapter([
            'driver' => 'InvalidDriver'
        ]);
    }

    public function testConstructorThrowsInvalidArgumentException()
    {
        $this->expectException('Soluble\Japha\Bridge\Exception\InvalidArgumentException');

        $ba = new Adapter([
            'driver' => 'Pjb62',
            'missing_servlet_address' => ''
        ]);
    }

    public function testConstructorThrowsInvalidArgumentException2()
    {
        $this->expectException('Soluble\Japha\Bridge\Exception\InvalidArgumentException');
        $ba = new Adapter([
            'driver' => 'Pjb62',
            'servlet_address' => 'an invalid url'
        ]);
    }

    public function testConstructorSetsCustomDefaultTimeZone()
    {
        $ba = new Adapter([
            'driver' => 'Pjb62',
            'servlet_address' => $this->servlet_address,
            'java_default_timezone' => 'Europe/London'
        ]);

        $javaTz = $ba->getSystem()->getTimeZoneId();
        self::assertEquals('Europe/London', $javaTz);
    }

    public function testConstructorWithDefaultriver()
    {
        $ba = new Adapter([
            'servlet_address' => $this->servlet_address,
        ]);

        $driverClass = get_class($ba->getDriver());
        self::assertEquals(Pjb62Driver::class, $driverClass);
    }

    public function testConstructorSetsInvalidDefaultTimeZoneThrowsException()
    {
        $this->expectException('Soluble\Japha\Util\Exception\UnsupportedTzException');
        $ba = new Adapter([
            'driver' => 'Pjb62',
            'servlet_address' => $this->servlet_address,
            'java_default_timezone' => 'InvalidTimezone'
        ]);
    }

    public function testConstructorSetsInvalidIniTimeZoneThrowsException()
    {
        $this->expectException('\Soluble\Japha\Util\Exception\UnsupportedTzException');

        // The 'Factory' timezone is supported in PHP, not in Java
        // and should produce an error
        $unsupportedJavaTz = 'Factory';

        $ba = new Adapter([
            'driver' => 'Pjb62',
            'servlet_address' => $this->servlet_address,
            'java_default_timezone' => $unsupportedJavaTz
        ]);
    }

    /*
     * This test demonstrate how dangerous it is to set
     * the global default timezone as it's shared by all clients instances
     * and shared by all threads/process/...
     */
    /*
    public function testThreadShareDefaultTimezone()
    {
        $ba = new Adapter([
            'driver' => 'Pjb62',
            'servlet_address' => $this->servlet_address,
            'java_default_timezone' => 'Europe/Brussels'
        ]);

        $scripts_path = \SolubleTestFactories::getScriptPath();
        $servlet_address = escapeshellarg(\SolubleTestFactories::getJavaBridgeServerAddress());

        $set_cmd = PHP_BINARY . " ${scripts_path}/set_thread_timezone.php $servlet_address";
        $get_cmd = PHP_BINARY . " ${scripts_path}/get_thread_timezone.php $servlet_address";

        $system = $ba->getSystem();

        // If you put it at true, will break because other threads have changed
        // the value.

        $enableCache = false;

        $originalTz = (string) $system->getTimeZone()->getDefault($enableCache)->getID();

        // The current Timezone default should be the same
        // as the one returned by an external thread
        $getThread1 = trim(exec("$get_cmd"));
        self::assertEquals($originalTz, $getThread1);

        // Setting the default timezone in this process
        $system->getTimeZone()->setDefault('Europe/London');
        self::assertEquals('Europe/London', (string) $system->getTimeZone()->getDefault($enableCache)->getID());

        // External processes will retrieve the same timezone
        $getThread2 = trim(exec("$get_cmd"));
        self::assertEquals('Europe/London', $getThread2);

        // Set timezone from an external process
        $setThread1 = trim(exec("$set_cmd Europe/Paris"));
        self::assertEquals('Europe/Paris', $setThread1);
        self::assertEquals('Europe/Paris', (string) $system->getTimeZone()->getDefault($enableCache)->getID());

        $getThread3 = trim(exec("$get_cmd"));
        self::assertEquals('Europe/Paris', $getThread3);
    }
    */
}
