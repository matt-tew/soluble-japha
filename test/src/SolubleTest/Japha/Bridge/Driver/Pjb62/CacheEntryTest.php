<?php

/*
 * Soluble Japha
 *
 * @link      https://github.com/belgattitude/soluble-japha
 * @copyright Copyright (c) 2013-2020 Vanvelthem Sébastien
 * @license   MIT License https://github.com/belgattitude/soluble-japha/blob/master/LICENSE.md
 */

namespace SolubleTest\Japha\Bridge\Driver\Pjb62;

use Soluble\Japha\Bridge\Adapter;
use Soluble\Japha\Bridge\Driver\Pjb62\CacheEntry;
use Soluble\Japha\Bridge\Driver\Pjb62\SimpleFactory;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-11-13 at 10:21:03.
 */
class CacheEntryTest extends TestCase
{
    /**
     * @var string
     */
    protected $servlet_address;

    /**
     * @var string
     */
    protected $options;

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
        $this->adapter = new Adapter([
            'driver' => 'Pjb62',
            'servlet_address' => $this->servlet_address,
        ]);
    }

    public function testCacheEntry()
    {
        $fmt = 'fmt';
        $signature = 'signature';
        $factory = new SimpleFactory($this->adapter->getDriver()->getClient()->getClient());
        $resultVoid = true;

        $ce = new CacheEntry($fmt, $signature, $factory, $resultVoid);

        self::assertEquals($fmt, $ce->fmt);
        self::assertEquals($signature, $ce->signature);
        self::assertEquals($factory, $ce->factory);
        self::assertTrue($ce->resultVoid);
    }
}
