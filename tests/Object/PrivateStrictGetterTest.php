<?php
namespace Teto\Object;

/**
 * @package    Teto
 * @subpackage Object
 * @copyright  2015 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @author     USAMI Kenta <tadsan@zonu.me>
 */
class PrivateStrictGetterTestObject
{
    use PrivateStrictGetter;

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
 * @package    Teto
 * @subpackage Object
 * @copyright  2015 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @author     USAMI Kenta <tadsan@zonu.me>
 */
class PrivateStrictGetterInteritedTestObject1 extends PrivateStrictGetterTestObject
{
    private $a = 'A1';
    private $b = 'B1';
    protected $c = 'C1';
    protected $d = 'D1';
    public $e = 'E1';
}

/**
 * @package    Teto
 * @subpackage Object
 * @copyright  2015 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @author     USAMI Kenta <tadsan@zonu.me>
 */
class PrivateStrictGetterInteritedTestObject2 extends PrivateStrictGetterTestObject
{
    use PrivateStrictGetter;

    private $a = 'A2';
    private $b = 'B2';
    public $e = 'E2';
}

/**
 * @package    Teto
 * @subpackage Object
 * @copyright  2015 USAMI Kenta
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @author     USAMI Kenta <tadsan@zonu.me>
 */
class PrivateStrictGetterTest extends \Teto\TestCase
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
            [new PrivateStrictGetterTestObject,           []],
            [new PrivateStrictGetterInteritedTestObject1, ['c' => 'C1', 'd' => 'D1', 'e' => 'E1']],
            [new PrivateStrictGetterInteritedTestObject2, ['a' => 'A2', 'b' => 'B2', 'e' => 'E2']],
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
            [new PrivateStrictGetterTestObject,           '\OutOfRangeException', 'x'],
            [new PrivateStrictGetterTestObject,           '\OutOfRangeException', 'y'],
            [new PrivateStrictGetterInteritedTestObject1, '\OutOfRangeException', 'x'],
            [new PrivateStrictGetterInteritedTestObject1, '\OutOfRangeException', 'y'],
            [new PrivateStrictGetterInteritedTestObject1, '\OutOfRangeException', 'z'],
            [new PrivateStrictGetterInteritedTestObject2, '\OutOfRangeException', 'x'],
            [new PrivateStrictGetterInteritedTestObject2, '\OutOfRangeException', 'y'],
            [new PrivateStrictGetterInteritedTestObject2, '\OutOfRangeException', 'z'],
        ];
    }
}
