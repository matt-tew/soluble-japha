<?php

/*
 * Soluble Japha
 *
 * @link      https://github.com/belgattitude/soluble-japha
 * @copyright Copyright (c) 2013-2017 Vanvelthem Sébastien
 * @license   MIT License https://github.com/belgattitude/soluble-japha/blob/master/LICENSE.md
 */

namespace SolubleTest\Japha\Bridge\Driver\Pjb62;

use Soluble\Japha\Bridge\Driver\Pjb62\ParserString;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-11-13 at 10:21:03.
 */
class ParserStringTest extends TestCase
{
    public function testParserString()
    {
        $pe = new ParserString();
        $pe->string = '1234';
        $pe->off = 0;
        $pe->length = 20;
        self::assertEquals('1234', $pe->getString());
        self::assertEquals('1234', $pe->toString());

        $pe->off = 1;
        $pe->length = 2;

        self::assertEquals('23', $pe->getString());
        self::assertEquals('23', $pe->toString());
    }

    public function testParserStringUTF8()
    {
        $pe = new ParserString();
        $pe->string = '你好，世界';
        $pe->off = 0;
        $pe->length = 20;
        self::assertEquals('你好，世界', $pe->getString());
        self::assertEquals('你好，世界', $pe->toString());
    }
}
