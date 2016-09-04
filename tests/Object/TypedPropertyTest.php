<?php

namespace Teto\Object;

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 *
 * @property int          $int_val
 * @property int[]        $inv_val_a
 * @property int|null     $int_val_n
 * @property int[]|null[] $int_val_na
 * @property string       $string_val
 */
final class TypedPropertyTestClass
{
    use TypedProperty;

    private static $property_types = [
        'int_val'    => 'int',
        'int_val_a'  => 'int[]',
        'int_val_a2' => 'int[2]',
        'int_val_n'  => '?int',
        'int_val_na' => '?int[]',
        'string_val' => 'string',
    ];
}

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
final class TypedPropertyTest extends \Teto\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test($name, $value)
    {
        $actual = new TypedPropertyTestClass;
        $this->assertNull($actual->$name);
        $this->assertEmpty($actual->$name);
        $this->assertFalse(isset($actual->$name));

        $actual->$name = $value;

        $this->assertSame($value, $actual->$name);
        $this->assertSame($value !== null, isset($actual->$name));
        $this->assertSame(empty($value), empty($actual->$name));
    }

    public function dataProviderFor_test()
    {
        return [
            ['int_val',    12345],
            ['int_val_a',  []],
            ['int_val_a',  [12345]],
            ['int_val_a',  [12345, 3939]],
            ['int_val_a2', [0410, 1010]],
            ['int_val_a',  new \ArrayIterator([12345, 3939])],
            ['int_val_n',  12345],
            ['int_val_n',  null],
            ['int_val_na', [12345]],
            ['int_val_na', []],
            ['int_val_na', [null]],
            ['int_val_na', [12345, null, 12345]],
            ['string_val', ''],
            ['string_val', 'mikumiku'],
            ['string_val', '12345'],
        ];
    }

    /**
     * @dataProvider dataProviderFor_test_set_raise_InvalidArgumentException
     */
    public function test_set_raise_InvalidArgumentException($name, $value, $expected_exception)
    {
        $this->setExpectedException($expected_exception);

        $actual = new TypedPropertyTestClass;
        $actual->$name = $value;
    }

    public function dataProviderFor_test_set_raise_InvalidArgumentException()
    {
        return [
            ['int_val',    null,            '\InvalidArgumentException'],
            ['int_val',    '12345',         '\InvalidArgumentException'],
            ['int_val',    [],              '\InvalidArgumentException'],
            ['int_val_a',  [12345, null],   '\InvalidArgumentException'],
            ['int_val_na', 12345,           '\InvalidArgumentException'],
            ['string_val', 12345,           '\InvalidArgumentException'],
            ['string_val', ['12345'],       '\InvalidArgumentException'],

            ['int_val_a2', [],              '\RangeException'],
            ['int_val_a2', [1010],          '\RangeException'],

            ['undef', ["It's undefined"],   '\OutOfRangeException'],
        ];
    }
}
