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
use function PHPUnit\Framework\assertNotInstanceOf;

class RGBTest extends TestCase
{
    /**
     * @test
     * @dataProvider failingDataset
     */
    public function it_fails_with_invalid_range($red, $green, $blue)
    {
        $this->expectException(InvalidArgument::class);

        $rgb = new RGB($red, $green, $blue);
    }

    /**
     * @return array
     */
    public function failingDataset(): array
    {
        return [
            [256, 100, 100],
            [-1, 100, 100],
            [100, 256, 100],
            [100, -1, 100],
            [100, 100, 256],
            [100, 100, -1],
        ];
    }

    /** @test
     * @throws InvalidArgument
     */
    public function it_stores_the_color()
    {
        $rgb = new RGB(200, 100, 0);

        assertEquals(200, $rgb->red());
        assertEquals(100, $rgb->green());
        assertEquals(0, $rgb->blue());
    }

    /** @test */
    public function it_defaults_to_black()
    {
        $rgb = new RGB();

        assertEquals(0, $rgb->red());
        assertEquals(0, $rgb->green());
        assertEquals(0, $rgb->blue());
    }

    /** @test */
    public function it_can_change_colors()
    {
        $rgb = new RGB(0, 0, 0);

        $rgb = $rgb->withRed(250);
        $rgb = $rgb->withGreen(150);
        $rgb = $rgb->withBlue(50);

        assertEquals(250, $rgb->red());
        assertEquals(150, $rgb->green());
        assertEquals(50, $rgb->blue());
    }

    /** @test */
    public function it_casts_to_string()
    {
        $rgb = new RGB(12, 34, 56);

        assertEquals('12,34,56', (string) $rgb);
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hex($hexData, $rgbData, $hslData, $c256Data)
    {
        $rgb = new RGB(...$rgbData);

        $hex = $rgb->toHEX()->withTemplate('# {code}');

        assertInstanceOf(HEX::class, $hex);
        assertEquals("# {$hexData}", (string) $hex);
    }

    /** @test */
    public function it_can_convert_to_rgb()
    {
        $rgb = new RGB(255, 153, 0);

        $clone = $rgb->toRGB()->withTemplate('{red}, {green}, {blue}');

        assertInstanceOf(RGB::class, $clone);
        assertNotEquals($rgb, $clone);
        assertEquals('255, 153, 0', (string) $clone);
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hsl($hexData, $rgbData, $hslData, $c256Data)
    {
        $rgb = new RGB(...$rgbData);

        $hsl = $rgb->toHSL()->withTemplate('{hue}deg {saturation}pct {lightness}pct');

        assertInstanceOf(HSL::class, $hsl);
        assertEquals("{$hslData[0]}deg {$hslData[1]}pct {$hslData[2]}pct", (string) $hsl);
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_256($hexData, $rgbData, $hslData, $c256Data)
    {
        $rgb = new RGB(...$rgbData);

        $c256 = $rgb->to256()->withTemplate(';{code}');

        assertInstanceOf(C256::class, $c256);
        assertEquals(";{$c256Data}", (string) $c256);
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
