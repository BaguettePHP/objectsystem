<?php

namespace Teto\Object;

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
class PrivateGetterTestObject
{
    use PrivateGetter;

    private $a = 'A';
    private $b;
    protected $c = 'C';
    protected $d;
    public $e = 'E';
    public $f = 'F';
    private static $x = 'X';
    protected static $y;
    private $z = 'Z';
}

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
class PrivateGetterInteritedTestObject1 extends PrivateGetterTestObject
{
    private $a = 'A1';
    private $b = 'B1';
    protected $c = 'C1';
    protected $d = 'D1';
    public $e = 'E1';
}

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
class PrivateGetterInteritedTestObject2 extends PrivateGetterTestObject
{
    use PrivateGetter;

    private $a = 'A2';
    private $b = 'B2';
    public $e = 'E2';
}

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
class PrivateGetterTest extends \Teto\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test($subject, array $diff)
    {
        $default_values = [
            'a' => 'A',
            'b' => null,
            'c' => 'C',
            'd' => null,
            'e' => 'E',
            'f' => 'F',
        ];
        $values_table = array_merge($default_values, $diff);

        foreach ($values_table as $name => $expected) {
            $this->assertEquals($expected,  $subject->$name);
            $this->assertEquals(isset($expected),  isset($subject->$name), "property: $name");
            $this->assertEquals(empty($expected),  empty($subject->$name), "property: $name");
        }
    }

    public function dataProviderFor_test()
    {
        return [
            [new PrivateGetterTestObject,           []],
            [new PrivateGetterInteritedTestObject1, ['c' => 'C1', 'd' => 'D1', 'e' => 'E1']],
            [new PrivateGetterInteritedTestObject2, ['a' => 'A2', 'b' => 'B2', 'e' => 'E2']],
        ];
    }

    /**
     * @dataProvider dataProviderFor_test_raiseException
     */
    public function test_raiseException($subject, $expected_exception, $name)
    {
        $this->setExpectedException($expected_exception);

        $_ = $subject->$name;
    }

    public function dataProviderFor_test_raiseException()
    {
        return [
            [new PrivateGetterTestObject,           '\PHPUnit_Framework_Error', 'x'],
            [new PrivateGetterTestObject,           '\PHPUnit_Framework_Error', 'y'],
            [new PrivateGetterInteritedTestObject1, '\PHPUnit_Framework_Error', 'x'],
            [new PrivateGetterInteritedTestObject1, '\PHPUnit_Framework_Error', 'y'],
            [new PrivateGetterInteritedTestObject2, '\PHPUnit_Framework_Error', 'x'],
            [new PrivateGetterInteritedTestObject2, '\PHPUnit_Framework_Error', 'y'],
            [new PrivateGetterInteritedTestObject2, '\PHPUnit_Framework_Error', 'z'],
        ];
    }
}
