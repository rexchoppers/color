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

class C256Test extends TestCase
{
    /**
     * @test
     * @dataProvider failingDataset
     */
    public function it_fails_with_invalid_code($code)
    {
        $this->expectException(InvalidArgument::class);

        $c256 = new C256($code);
    }

    /**
     * @return array
     */
    public function failingDataset(): array
    {
        return [
            [-1],
            [256],
        ];
    }

    /** @test */
    public function it_stores_the_color()
    {
        $c256 = new C256(51);

        assertEquals(51, $c256->code());
    }

    /** @test */
    public function it_defaults_to_black()
    {
        $c256 = new C256();

        assertEquals(232, $c256->code());
    }

    /** @test */
    public function it_casts_to_string()
    {
        $c256 = new C256(232);

        assertEquals('232', (string) $c256);
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hex($c256Data, $hexData, $rgbData, $hslData)
    {
        $c256 = new C256($c256Data);

        $hex = $c256->toHEX()->withTemplate('# {code}');

        assertInstanceOf(HEX::class, $hex);
        assertEquals("# {$hexData}", (string) $hex);
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_rgb($c256Data, $hexData, $rgbData, $hslData)
    {
        $c256 = new C256($c256Data);

        $rgb = $c256->toRGB()->withTemplate('{red}, {green}, {blue}');

        assertInstanceOf(RGB::class, $rgb);
        assertEquals("{$rgbData[0]}, {$rgbData[1]}, {$rgbData[2]}", (string) $rgb);
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hsl($c256Data, $hexData, $rgbData, $hslData)
    {
        $c256 = new C256($c256Data);

        $hsl = $c256->toHSL()->withTemplate('{hue}deg {saturation}pct {lightness}pct');

        assertInstanceOf(HSL::class, $hsl);
        assertEquals("{$hslData[0]}deg {$hslData[1]}pct {$hslData[2]}pct", (string) $hsl);
    }

    /** @test */
    public function it_can_convert_to_256()
    {
        $c256 = new C256(16);

        $clone = $c256->to256()->withTemplate(';{code}');

        assertInstanceOf(C256::class, $clone);
        assertNotEquals($c256, $clone);
        assertEquals(';16', (string) $clone);
    }

    /**
     * @return array
     */
    public function colorsDataset(): array
    {
        return [
            ['c256' => 16, 'hex' => '000000', 'rgb' => [0, 0, 0], 'hsl' => [0, 0, 0]],
            ['c256' => 32, 'hex' => '0087D7', 'rgb' => [0, 135, 215], 'hsl' => [202, 100, 42]],
            ['c256' => 70, 'hex' => '5FAF00', 'rgb' => [95, 175, 0], 'hsl' => [87, 100, 34]],
            ['c256' => 93, 'hex' => '8700FF', 'rgb' => [135, 0, 255], 'hsl' => [272, 100, 50]],
            ['c256' => 124, 'hex' => 'AF0000', 'rgb' => [175, 0, 0], 'hsl' => [0, 100, 34]],
            ['c256' => 171, 'hex' => 'D75FFF', 'rgb' => [215, 95, 255], 'hsl' => [285, 100, 69]],
            ['c256' => 208, 'hex' => 'FF8700', 'rgb' => [255, 135, 0], 'hsl' => [32, 100, 50]],
            ['c256' => 231, 'hex' => 'FFFFFF', 'rgb' => [255, 255, 255], 'hsl' => [0, 0, 100]],
            ['c256' => 232, 'hex' => '080808', 'rgb' => [8, 8, 8], 'hsl' => [0, 0, 3]],
            ['c256' => 244, 'hex' => '808080', 'rgb' => [128, 128, 128], 'hsl' => [0, 0, 50]],
            ['c256' => 255, 'hex' => 'EEEEEE', 'rgb' => [238, 238, 238], 'hsl' => [0, 0, 93]],
        ];
    }
}
