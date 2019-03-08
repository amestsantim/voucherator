<?php

namespace Tests\Unit;

use AmestSantim\Voucherator\VoucherGenerator;
use AmestSantim\Voucherator\VoucherTransformer;
use PHPUnit\Framework\TestCase;

class VoucherTest extends TestCase
{
    protected $generator;

    protected function setUp():void
    {
        parent::setUp();
        $this->generator = new VoucherGenerator();
    }

    public function testConstructor()
    {
        $this->assertEquals(array_merge(range(0, 9), range('a', 'z'), range('A', 'Z')), $this->generator->charSet());
    }

    private function checkCountAndLength($arr, $count, $length)
    {
        $this->assertIsArray($arr);
        $this->assertEquals($count, count($arr));
        $green = true;
        foreach ($arr as $item) {
            $green = $green || ($length === strlen($item));
        }
        $this->assertTrue($green);
    }

    public function testDefaultGenerateMethod()
    {
        $generated = $this->generator->generate(3);
        $this->checkCountAndLength($generated, 3, 8);
    }

    public function testLengthMethod()
    {
        $generated = $this->generator->generate(2);
        $this->checkCountAndLength($generated, 2, 12);
    }

    public function testExcludeMethod()
    {
        $this->assertFalse(in_array('A', $this->generator->letters()->exclude('A')->charSet()));
    }

    public function testAugmentMethod()
    {
        $this->assertTrue(in_array('#', $this->generator->letters()->augment('#')->charSet()));
    }

    public function testNumeralsMethod()
    {
        $this->assertEquals(range(0, 9), $this->generator->numerals()->charSet());
    }

    public function testUpperCaseMethod()
    {
        $this->assertEquals(range('A', 'Z'), $this->generator->letters()->upperCase()->charSet());
    }

    public function testLowerCaseMethod()
    {
        $this->assertEquals(range('a', 'z'), $this->generator->letters()->lowerCase()->charSet());
    }

    public function testCapitalizeFirstCharacter()
    {
        $generated = $this->generator->generate();
        $generated = VoucherTransformer::capitalizeFirstCharacter($generated);
        $this->assertEquals(ucfirst($generated[0])[0], $generated[0][0]);
    }

    public function testAddSeparator()
    {
        $generated = $this->generator->generate();
        $generated = VoucherTransformer::addSeparator($generated, 4, '-');
        $pieces = explode('-', $generated[0]);
        $this->assertEquals(2, count($pieces));
        $this->assertEquals(4, strlen($pieces[0]));
        $this->assertEquals(4, strlen($pieces[1]));
    }

    public function testPrefix()
    {
        $generated = $this->generator->generate();
        $generated = VoucherTransformer::addPrefix($generated, 'ET');
        $this->assertEquals('ET', substr($generated[0], 0, 2));
    }
}
