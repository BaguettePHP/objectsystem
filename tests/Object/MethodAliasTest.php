<?php

namespace Teto\Object;

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
class MethodAliasTestClass
{
    use MethodAlias;

    private $string;

    private static $method_aliases = [
        'mlen' => 'mb_strlen',
    ];

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function mb_strlen()
    {
        return mb_strlen($this->string, 'UTF-8');
    }
}

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
class MethodAliasTest extends \Teto\TestCase
{
    public function test()
    {
        $val = new MethodAliasTestClass('ぬるぽ');

        $this->assertEquals($val->mb_strlen(), $val->mlen());
    }

    public function test_raiseError()
    {
        $val = new MethodAliasTestClass('ぬるぽ');
        $this->setExpectedException('\BadMethodCallException', "MethodAliasTestClass::unknown() is not exists.");

        $_ = $val->unknown();
    }
}
