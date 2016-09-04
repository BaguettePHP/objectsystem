<?php

namespace Teto\Object;

/**
 * @package   Teto\Object\tests
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2016 Baguette HQ
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
final class TypeDefinitionTest extends \Teto\TestCase
{
    /**
     * @dataProvider dataProviderFor_test_assertValue_success
     */
    public function test_assertValue_success(
        $def, $expected, $is_nullable, $is_array, $len
    ) {
        $actual = TypeDefinition::parse($def);

        $this->assertSame($expected,    $actual->expected);
        $this->assertSame($is_nullable, $actual->is_nullable);
        $this->assertSame($is_array,    $actual->is_array);
        $this->assertSame($len,         $actual->len);
    }

    public function dataProviderFor_test_assertValue_success()
    {
        // def * expected * is_nullable * is_array * len
        return [
            ['string',     'string', false, false, null],
            ['?string',    'string', true,  false, null],
            ['string[]',   'string', false, true,  null],
            ['string[5]',  'string', false, true,  5],
            ['?string[5]', 'string', true,  true,  5],
        ];
    }

    /**
     * @dataProvider dataProviderFor_test_assertValue_throwsException
     */
    public function test_assertValue_throwsException($def, $expected_exception)
    {
        $this->setExpectedException($expected_exception);

        $actual = TypeDefinition::parse($def);
    }

    public function dataProviderFor_test_assertValue_throwsException()
    {
        // def * expected
        return [
            ['',         '\LogicException'],
            ['?',        '\LogicException'],
            ['[]',       '\LogicException'],
            ['[5]',      '\LogicException'],
            ['string[5', '\LogicException'],
        ];
    }
}
