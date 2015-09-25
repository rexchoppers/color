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

        $clone = $hex->toHEX()->withTemplate('# {code}');

        assertThat($clone, is(anInstanceOf(HEX::class)));
        assertThat($clone, is(not(sameInstance($hex))));
        assertThat((string) $clone, is('# FF9900'));
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_rgb($hexData, $rgbData, $hslData)
    {
        $hex = new HEX($hexData);

        $rgb = $hex->toRGB()->withTemplate('{red}, {green}, {blue}');

        assertThat($rgb, is(anInstanceOf(RGB::class)));
        assertThat((string) $rgb, is("{$rgbData[0]}, {$rgbData[1]}, {$rgbData[2]}"));
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hsl($hexData, $rgbData, $hslData)
    {
        $hex = new HEX($hexData);

        $hsl = $hex->toHSL()->withTemplate('{hue}deg {saturation}pct {lightness}pct');

        assertThat($hsl, is(anInstanceOf(HSL::class)));
        assertThat((string) $hsl, is("{$hslData[0]}deg {$hslData[1]}pct {$hslData[2]}pct"));
    }

    /**
     * @return array
     */
    public function colorsDataset()
    {
        return [
            ['hex' => '000000', 'rgb' => [0, 0, 0], 'hsl' => [0, 0, 0]],
            ['hex' => 'FFFFFF', 'rgb' => [255, 255, 255], 'hsl' => [0, 0, 100]],
            ['hex' => '7F7F7F', 'rgb' => [127, 127, 127], 'hsl' => [0, 0, 50]],
            ['hex' => 'FF0000', 'rgb' => [255, 0, 0], 'hsl' => [0, 100, 50]],
            ['hex' => '00FF00', 'rgb' => [0, 255, 0], 'hsl' => [120, 100, 50]],
            ['hex' => '0000FF', 'rgb' => [0, 0, 255], 'hsl' => [240, 100, 50]],
            ['hex' => '00FFFF', 'rgb' => [0, 255, 255], 'hsl' => [180, 100, 50]],
            ['hex' => 'FF00FF', 'rgb' => [255, 0, 255], 'hsl' => [300, 100, 50]],
            ['hex' => 'FFFF00', 'rgb' => [255, 255, 0], 'hsl' => [60, 100, 50]],
            ['hex' => 'FF5F47', 'rgb' => [255, 95, 71], 'hsl' => [8, 100, 64]],
            ['hex' => 'FF7565', 'rgb' => [255, 117, 101], 'hsl' => [6, 100, 70]],
        ];
    }
}
