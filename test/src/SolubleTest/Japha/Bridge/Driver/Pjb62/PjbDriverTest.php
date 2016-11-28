<?php

namespace SolubleTest\Japha\Bridge\Driver\Pjb62;

use Soluble\Japha\Bridge\Adapter;
use Soluble\Japha\Bridge\Driver\Pjb62\InternalJava;
use Soluble\Japha\Bridge\Driver\Pjb62\PjbProxyClient;
use Soluble\Japha\Interfaces\JavaObject;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-11-13 at 10:21:03.
 */
class Pjb62DriverTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var string
     */
    protected $servlet_address;

    /**
     * @var string
     */
    protected $options;

    /**
     *
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
        $this->adapter = new Adapter([
            'driver' => 'Pjb62',
            'servlet_address' => $this->servlet_address,
        ]);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testGetClient()
    {
        $client = $this->adapter->getDriver()->getClient();
        $this->assertInstanceOf(PjbProxyClient::class, $client);
    }

    public function testJavaContext()
    {
        $context = $this->adapter->getDriver()->getJavaContext();
        $this->assertInstanceOf(JavaObject::class, $context);
        $this->assertInstanceOf(InternalJava::class, $context);

        $fqdn = $this->adapter->getClassName($context);
        $this->assertEquals('php.java.bridge.http.Context', $fqdn);
    }
}
