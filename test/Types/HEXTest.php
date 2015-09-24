<?php

namespace Tests\Color\Types;

use Color\Types\HEX;
use Color\Types\HSL;
use Color\Types\RGB;
use Color\Exceptions\InvalidArgument;

class HEXTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider failingDataset
     */
    public function it_fails_with_invalid_code($code)
    {
        $this->setExpectedException(InvalidArgument::class);

        $hex = new HEX($code);
    }

    /**
     * @return array
     */
    public function failingDataset()
    {
        return [
            [1],
            [12],
            [1234],
            [1234567],
            [''],
            ['a'],
            ['ab'],
            ['abcd'],
            ['abcdeff'],
            ['gggggg'],
        ];
    }

    /** @test */
    public function it_stores_the_color()
    {
        $hex = new HEX('ABCDEF');

        assertThat($hex->code(), is('ABCDEF'));
    }

    /** @test */
    public function it_defaults_to_black()
    {
        $hex = new HEX();

        assertThat($hex->code(), is('00000'));
    }

    /**
     * @test
     * @dataProvider validDataset
     */
    public function it_sanitizes_the_code($before, $after)
    {
        $hex = new HEX($before);

        assertThat($hex->code(), is(equalTo($after)));
    }

    /**
     * @return array
     */
    public function validDataset()
    {
        return [
            [123, '112233'],
            [987654, '987654'],
            ['aBc', 'AABBCC'],
            ['FeDcBa', 'FEDCBA'],
            ['#1B5', '11BB55'],
            ['#1a2b3c', '1A2B3C'],
        ];
    }

    /** @test */
    public function it_casts_to_string()
    {
        $hex = new HEX('ABCDEF');

        assertThat((string) $hex, is('#ABCDEF'));
    }

    /** @test */
    public function it_can_convert_to_hex()
    {
        $hex = new HEX('FF9900');

        $clone = $hex->toHEX();

        assertThat($clone, is(anInstanceOf(HEX::class)));
        assertThat($clone, is(not(sameInstance($hex))));
        assertThat((string) $clone, is('#FF9900'));
    }

    /** @test */
    public function it_can_convert_to_rgb()
    {
        $hex = new HEX('FF9900');

        $rgb = $hex->toRGB();

        assertThat($rgb, is(anInstanceOf(RGB::class)));
        assertThat((string) $rgb, is('255,153,0'));
    }

//    /** @test */
//    public function it_can_convert_to_hsl()
//    {
//        $hex = new HEX('FF9900');
//
//        $hsl = $hex->toHSL();
//
//        assertThat($hsl, is(anInstanceOf(HSL::class)));
//        assertThat((string) $hsl, is('255° 153% 0%'));
//    }
}
