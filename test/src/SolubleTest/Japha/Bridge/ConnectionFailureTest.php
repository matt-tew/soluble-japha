<?php

/*
 * Soluble Japha
 *
 * @link      https://github.com/belgattitude/soluble-japha
 * @copyright Copyright (c) 2013-2020 Vanvelthem Sébastien
 * @license   MIT License https://github.com/belgattitude/soluble-japha/blob/master/LICENSE.md
 */

namespace SolubleTest\Japha\Bridge;

use Soluble\Japha\Bridge\Adapter;
use Soluble\Japha\Bridge\Driver\Pjb62\PjbProxyClient;
use PHPUnit\Framework\TestCase;
use Soluble\Japha\Bridge\Exception\BrokenConnectionException;
use Soluble\Japha\Bridge\Exception\ConnectionException;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-11-04 at 16:47:42.
 */
class ConnectionFailureTest extends TestCase
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

    public function testServerDownThrowsConnectionException(): void
    {
        $this->expectException(ConnectionException::class);
        PjbProxyClient::unregisterInstance();
        new Adapter([
            'driver' => 'pjb62',
            //'servlet_address' => $this->servlet_address . 'urldoesnotexists'
            'servlet_address' => 'http://127.0.0.1:12345/servlet.phpjavabridge'
        ]);
    }

    public function testServerDownThrowsConnectionException2(): void
    {
        $this->expectException(BrokenConnectionException::class);
        PjbProxyClient::unregisterInstance();
        $invalid_address = str_replace('servlet.phpjavabridge', 'invalid/uri', $this->servlet_address);

        $ba = new Adapter([
            'driver' => 'pjb62',
            'servlet_address' => $invalid_address
        ]);
        $ba->java('java.lang.String', 'Bouyou');
    }
}
