<?php

namespace Teto\Object;

use function get_class;
use function sprintf;

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
class ReadOnlyTestObject
{
    use ReadOnlyTrait;

    public $public = 'PubliC';

    protected $protected = 'ProtecteD';

    private $private = 'PrivatE';
}

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
class ReadOnlyTest extends \Teto\TestCase
{
    public function test()
    {
        $actual = new ReadOnlyTestObject();
        $actual->public = 'XXXXX';

        $this->assertSame('XXXXX', $actual->public);
    }

    /**
     * @dataProvider dataProvider_test_throws_OutOfRangeException
     */
    public function test_throws_OutOfRangeException($name)
    {
        $actual = new ReadOnlyTestObject();
        $expected_message = sprintf('%s->%s is not writable property.', get_class($actual), $name);
        $this->expectException(\OutOfRangeException::class, $expected_message);

        $actual->$name = 'YYYYY';
    }

    public function dataProvider_test_throws_OutOfRangeException()
    {
        return [
            ['protected'],
            ['private'],
            ['undefProperty'],
        ];
    }
}
