<?php

namespace Teto\Object;

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
final class TypeAssertTestClass
{
    use TypeAssert;

    protected static $enum_values = [
        'fruit' => ['apple', 'orange', 'banana', 'kaki', 'melon'],
    ];

    public static function __callStatic($name, array $arguments)
    {
        return call_user_func_array("self::$name", $arguments);
    }
}

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
final class TypeAssertTest extends \Teto\TestCase
{
    /**
     * @dataProvider dataProviderFor_test_assertValue_success
     */
    public function test_assertValue_success($expected_type, $value, $name = 'var')
    {
        TypeAssertTestClass::assertValue($expected_type, $name, $value, false);
    }

    public function dataProviderFor_test_assertValue_success()
    {
        return [
            ['string',    'a'],
            ['string',    '1'],
            ['int',       1],
            ['int',       10000000000000],
            ['float',     1.0],
            ['float',     10000000000000000000000],
            ['enum',      'apple', 'fruit'],
            ['bool',      true],
            ['bool',      false],
            ['callable',  function(){} ],
            ['callable',  [dir('.'), 'close']],
            ['callable',  'Datetime::createFromFormat'],
            ['object',    new \stdClass],
            ['stdClass',  new \stdClass],
            ['\stdClass', new \stdClass],
        ];
    }

    /**
     * @dataProvider dataProviderFor_test_assertValue_raise_InvalidArgumentException
     */
    public function test_assertValue_raise_InvalidArgumentException($expected_type, $value, $name = null)
    {
        $name = str_replace('\\', '', $name ?: "not${expected_type}Val");
        $expected_type = str_replace('\\', '', $expected_type);

        if ($expected_type === 'enum') {
            $msg = "/got \\$$name as .+ \(expects \[.+\]\)/";
        } else {
            $msg = "/got \\$$name as .+ \(expects $expected_type\)/";
        }

        $this->setExpectedExceptionRegExp('InvalidArgumentException', $msg);

        TypeAssertTestClass::assertValue($expected_type, $name, $value, false);
    }

    public function dataProviderFor_test_assertValue_raise_InvalidArgumentException()
    {
        return [
            ['string',    1],
            ['float',     1],
            ['float',     10000000000000],
            ['int',       'a'],
            ['int',       '1'],
            ['int',       1.0],
            ['int',       10000000000000000000000],
            ['enum',      'mango', 'fruit'],
            ['bool',      'true'],
            ['bool',      'false'],
            ['DateTime',  new \stdClass],
            ['\DateTime', new \stdClass],
        ];
    }

    /**
     * @dataProvider dataProviderFor_test_assertInt
     */
    public function test_assertInt($num, $raise_error = false)
    {
        if ($raise_error) {
            $msg = '/got \\$.+ \(expects int\)/';
            $this->setExpectedExceptionRegExp('InvalidArgumentException', $msg);
        }

        TypeAssertTestClass::assertInt($num);
        TypeAssertTestClass::assertValue('int', 'IntVal', $num, false);
    }

    public function dataProviderFor_test_assertInt()
    {
        static $data = [
            [1],
            [10000000000000],
            [1.0,                     true],
            [10000000000000000000000, true],
        ];

        return $data;
    }
}
