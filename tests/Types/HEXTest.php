<?php

namespace Scriptura\Color\Tests\Types;

use PHPUnit\Framework\TestCase;
use Scriptura\Color\Types\C256;
use Scriptura\Color\Types\HEX;
use Scriptura\Color\Types\HSL;
use Scriptura\Color\Types\RGB;
use Scriptura\Color\Exceptions\InvalidArgument;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotEquals;

class HEXTest extends TestCase
{
    /**
     * @test
     * @dataProvider failingDataset
     */
    public function it_fails_with_invalid_code($code)
    {
        $this->expectException(InvalidArgument::class);

        $hex = new HEX($code);
    }

    /**
     * @return array
     */
    public function failingDataset(): array
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

        assertEquals($hex->code(), 'ABCDEF');
    }

    /** @test */
    public function it_defaults_to_black()
    {
        $hex = new HEX();

        assertEquals($hex->code(), '000000');
    }

    /**
     * @test
     * @dataProvider validDataset
     */
    public function it_sanitizes_the_code($before, $after)
    {
        $hex = new HEX($before);

        assertEquals($hex->code(), $after);
    }

    /**
     * @return array
     */
    public function validDataset(): array
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

        assertEquals((string) $hex, '#ABCDEF');
    }

    /** @test */
    public function it_can_convert_to_hex()
    {
        $hex = new HEX('FF9900');

        $clone = $hex->toHEX()->withTemplate('# {code}');

        assertInstanceOf(HEX::class, $clone);
        assertNotEquals($clone, $hex);
        assertEquals((string) $clone, '# FF9900');
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_rgb($hexData, $rgbData, $hslData, $c256Data)
    {
        $hex = new HEX($hexData);

        $rgb = $hex->toRGB()->withTemplate('{red}, {green}, {blue}');

        assertInstanceOf(RGB::class, $rgb);
        assertEquals((string) $rgb, "{$rgbData[0]}, {$rgbData[1]}, {$rgbData[2]}");
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hsl($hexData, $rgbData, $hslData, $c256Data)
    {
        $hex = new HEX($hexData);

        $hsl = $hex->toHSL()->withTemplate('{hue}deg {saturation}pct {lightness}pct');

        assertInstanceOf(HSL::class, $hsl);
        assertEquals((string) $hsl, "{$hslData[0]}deg {$hslData[1]}pct {$hslData[2]}pct");
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_256($hexData, $rgbData, $hslData, $c256Data)
    {
        $hex = new HEX($hexData);

        $c256 = $hex->to256()->withTemplate(';{code}');

        assertInstanceOf(C256::class, $c256);
        assertEquals((string) $c256, ";{$c256Data}");
    }

    /**
     * @return array
     */
    public function colorsDataset(): array
    {
        return [
            ['hex' => '000000', 'rgb' => [0, 0, 0], 'hsl' => [0, 0, 0], 'c256' => 16],
            ['hex' => 'FFFFFF', 'rgb' => [255, 255, 255], 'hsl' => [0, 0, 100], 'c256' => 231],
            ['hex' => '808080', 'rgb' => [128, 128, 128], 'hsl' => [0, 0, 50], 'c256' => 244],
            ['hex' => 'FF0000', 'rgb' => [255, 0, 0], 'hsl' => [0, 100, 50], 'c256' => 196],
            ['hex' => '00FF00', 'rgb' => [0, 255, 0], 'hsl' => [120, 100, 50], 'c256' => 46],
            ['hex' => '0000FF', 'rgb' => [0, 0, 255], 'hsl' => [240, 100, 50], 'c256' => 21],
            ['hex' => '00FFFF', 'rgb' => [0, 255, 255], 'hsl' => [180, 100, 50], 'c256' => 51],
            ['hex' => 'FF00FF', 'rgb' => [255, 0, 255], 'hsl' => [300, 100, 50], 'c256' => 201],
            ['hex' => 'FFFF00', 'rgb' => [255, 255, 0], 'hsl' => [60, 100, 50], 'c256' => 226],
            ['hex' => 'FF6047', 'rgb' => [255, 96, 71], 'hsl' => [8, 100, 64], 'c256' => 203],
            ['hex' => 'FF7566', 'rgb' => [255, 117, 102], 'hsl' => [6, 100, 70], 'c256' => 209],
        ];
    }
}
