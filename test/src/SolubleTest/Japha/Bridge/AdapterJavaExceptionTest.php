<?php

namespace SolubleTest\Japha\Bridge;

use Soluble\Japha\Bridge\Adapter;
use Soluble\Japha\Bridge\Exception;
use Soluble\Japha\Util\Exception\UnsupportedTzException;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-11-04 at 16:47:42.
 */
class AdapterJavaExceptionTest extends \PHPUnit_Framework_TestCase
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

    public function testGetDriver()
    {
        $driver = $this->adapter->getDriver();
        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\AbstractDriver', $driver);
    }

    public function testJavaExceptionInterfaceMethods()
    {
        $ba = $this->adapter;

        try {
            $string = $ba->java('java.lang.String', 'Hello world');
            $string->anInvalidMethod();
            $this->assertFalse(true, 'This code cannot be reached');
        } catch (Exception\NoSuchMethodException $e) {
            $this->assertInstanceOf(Exception\JavaExceptionInterface::class, $e);

            $stackTrace = $e->getStackTrace();
            $this->assertInternalType('string', $stackTrace);

            $cause = $e->getCause();
            $this->assertInternalType('string', $cause);
            $this->assertStringStartsWith('java.lang.NoSuchMethodException: anInvalidMethod()', $cause);

            $message = $e->getMessage();
            $this->assertInternalType('string', $message);
            $this->assertContains('java.lang.NoSuchMethodException', $message);
            $this->assertContains('[[o:String]]->anInvalidMethod', $message);

            $javaClassName = $e->getJavaClassName();
            $this->assertInternalType('string', $javaClassName);
            $this->assertEquals('java.lang.NoSuchMethodException', $javaClassName);

            $driverException = $e->getDriverException();
            $this->assertInstanceOf(\Exception::class, $driverException);
        } catch (\Exception $e) {
            $this->assertFalse(true, 'This code cannot be reached');
        }
    }

    public function testCommonExceptions()
    {
        $ba = $this->adapter;

        try {
            $string = $ba->java('java.lang.String', 'Hello world');
            $string->anInvalidMethod();
            $this->assertFalse(true, 'This code cannot be reached');
        } catch (Exception\NoSuchMethodException $e) {
            $this->assertInstanceOf(Exception\JavaExceptionInterface::class, $e);
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertFalse(true, 'This code cannot be reached');
        }

        // Class not found
        try {
            $string = $ba->java('java.INVALID.String', 'Hello world');
            $this->assertFalse(true, 'This code cannot be reached');
        } catch (Exception\ClassNotFoundException $e) {
            $this->assertInstanceOf(Exception\JavaExceptionInterface::class, $e);
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertFalse(true, 'This code cannot be reached');
        }

        try {
            $string = $ba->java('java.Invalid.String', 'Hello world');
        } catch (Exception\JavaException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertFalse(true, 'This code cannot be reached');
        }
    }

    public function testExceptionToString()
    {
        $ba = $this->adapter;

        try {
            $ba = new Adapter([
                'driver' => 'Pjb62',
                'servlet_address' => $this->servlet_address,
                'java_default_timezone' => 'InvalidTimezone'
            ]);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exception\RuntimeException::class, $e);
            $this->assertInstanceOf(UnsupportedTzException::class, $e);
            $this->assertTrue(true);
            $this->assertInternalType('string', $e->__toString());
        }
    }
}
