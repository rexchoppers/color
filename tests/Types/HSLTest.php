<?php

namespace Scriptura\Color\Tests\Types;

use PHPUnit\Framework\TestCase;
use Scriptura\Color\Exceptions\InvalidArgument;
use Scriptura\Color\Types\C256;
use Scriptura\Color\Types\HEX;
use Scriptura\Color\Types\HSL;
use Scriptura\Color\Types\RGB;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotEquals;

class HSLTest extends TestCase
{
    /**
     * @test
     * @dataProvider failingDataset
     */
    public function it_fails_with_invalid_range($hue, $saturation, $lightness)
    {
        $this->expectException(InvalidArgument::class);

        $hsl = new HSL($hue, $saturation, $lightness);
    }

    /**
     * @return array
     */
    public function failingDataset(): array
    {
        return [
            [-1, 50, 50],
            [361, 50, 50],
            [180, -1, 50],
            [180, 101, 50],
            [180, 50, -1],
            [180, 50, 101],
        ];
    }

    /** @test */
    public function it_stores_the_color()
    {
        $hsl = new HSL(180, 50, 50);

        assertEquals(180, $hsl->hue());
        assertEquals(50, $hsl->saturation());
        assertEquals(50, $hsl->lightness());
    }

    /** @test */
    public function it_defaults_to_black()
    {
        $hsl = new HSL();

        assertEquals(0, $hsl->hue());
        assertEquals(0, $hsl->saturation());
        assertEquals( 0, $hsl->lightness());
    }

    /** @test
     * @throws InvalidArgument
     */
    public function it_can_change_colors()
    {
        $hsl = new HSL(0, 0, 0);

        $hsl = $hsl->withHue(90);
        $hsl = $hsl->withSaturation(75);
        $hsl = $hsl->withLightness(25);

        assertEquals(90, $hsl->hue());
        assertEquals(75, $hsl->saturation());
        assertEquals(25, $hsl->lightness());
    }

    /** @test */
    public function it_casts_to_string()
    {
        $hsl = new HSL(0, 100, 50);

        assertEquals('0° 100% 50%', (string) $hsl);
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hex($hexData, $rgbData, $hslData, $c256Data)
    {
        $hsl = new HSL(...$hslData);

        $hex = $hsl->toHEX()->withTemplate('# {code}');

        assertInstanceOf(HEX::class, $hex);
        assertEquals("# {$hexData}", (string) $hex);
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_rgb($hexData, $rgbData, $hslData, $c256Data)
    {
        $hsl = new HSL(...$hslData);

        $rgb = $hsl->toRGB()->withTemplate('{red}, {green}, {blue}');

        assertInstanceOf(RGB::class, $rgb);
        assertEquals("{$rgbData[0]}, {$rgbData[1]}, {$rgbData[2]}", (string) $rgb);
    }

    /** @test */
    public function it_can_convert_to_hsl()
    {
        $hsl = new HSL(0, 100, 50);

        $clone = $hsl->toHSL()->withTemplate('{hue}deg {saturation}pct {lightness}pct');

        assertInstanceOf(HSL::class, $clone);
        assertNotEquals($hsl, $clone);
        assertEquals('0deg 100pct 50pct', (string) $clone);
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_256($hexData, $rgbData, $hslData, $c256Data)
    {
        $hsl = new HSL(...$hslData);

        $c256 = $hsl->to256()->withTemplate(';{code}');

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

    /** @test */
    public function it_can_lighten_a_color()
    {
        $hsl = new HSL(0, 100, 25, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->lighten(25);

        assertEquals('0deg 100pct 50pct', (string) $hsl);
    }

    /** @test */
    public function it_limits_lightness_to_100_when_lightening()
    {
        $hsl = new HSL(0, 100, 90, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->lighten(11);

        assertEquals('0deg 100pct 100pct', (string) $hsl);
    }

    /** @test */
    public function it_can_darken_a_color()
    {
        $hsl = new HSL(0, 100, 50, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->darken(25);

        assertEquals('0deg 100pct 25pct', (string) $hsl);
    }

    /** @test */
    public function it_limits_lightness_to_0_when_darkenening()
    {
        $hsl = new HSL(0, 100, 10, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->darken(11);

        assertEquals('0deg 100pct 0pct', (string) $hsl);
    }

    /** @test */
    public function it_can_saturate_a_color()
    {
        $hsl = new HSL(0, 25, 50, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->saturate(25);

        assertEquals('0deg 50pct 50pct', (string) $hsl);
    }

    /** @test */
    public function it_limits_saturation_to_100_when_saturating()
    {
        $hsl = new HSL(0, 90, 50, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->saturate(11);

        assertEquals('0deg 100pct 50pct', (string) $hsl);
    }

    /** @test */
    public function it_can_desaturate_a_color()
    {
        $hsl = new HSL(0, 50, 50, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->desaturate(25);

        assertEquals('0deg 25pct 50pct', (string) $hsl);
    }

    /** @test */
    public function it_limits_saturation_to_0_when_desaturating()
    {
        $hsl = new HSL(0, 10, 50, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->desaturate(11);

        assertEquals('0deg 0pct 50pct', (string) $hsl);
    }

    /**
     * @test
     * @dataProvider mixDataset
     */
    public function it_can_mix_two_colors_and_return_the_mixed_color($one, $two, $mix)
    {
        $first = new HSL(...$one);
        $second = new HSL(...$two);

        $mixed = $first->mix($second);

        assertEquals("{$mix[0]}deg {$mix[1]}pct {$mix[2]}pct", (string) $mixed->withTemplate('{hue}deg {saturation}pct {lightness}pct'));
    }

    /**
     * @return array
     */
    public function mixDataset(): array
    {
        return [
            ['one' => [0, 100, 50], 'two' => [120, 100, 50], 'mix' => [60, 100, 50]],
            ['one' => [120, 100, 50], 'two' => [240, 100, 50], 'mix' => [180, 100, 50]],
            ['one' => [240, 100, 50], 'two' => [360, 100, 50], 'mix' => [300, 100, 50]],
            ['one' => [344, 70, 31], 'two' => [112, 90, 78], 'mix' => [48, 80, 54]],
            ['one' => [209, 12, 57], 'two' => [311, 80, 38], 'mix' => [260, 46, 47]],
        ];
    }
}
