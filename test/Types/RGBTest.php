<?php

namespace Tests\Color\Types;

use Color\Types\C256;
use Color\Types\HEX;
use Color\Types\HSL;
use Color\Types\RGB;
use Color\Exceptions\InvalidArgument;

class RGBTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider failingDataset
     */
    public function it_fails_with_invalid_range($red, $green, $blue)
    {
        $this->setExpectedException(InvalidArgument::class);

        $rgb = new RGB($red, $green, $blue);
    }

    /**
     * @return array
     */
    public function failingDataset()
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

    /** @test */
    public function it_stores_the_color()
    {
        $rgb = new RGB(200, 100, 0);

        assertThat($rgb->red(), is(200));
        assertThat($rgb->green(), is(100));
        assertThat($rgb->blue(), is(0));
    }

    /** @test */
    public function it_defaults_to_black()
    {
        $rgb = new RGB();

        assertThat($rgb->red(), is(0));
        assertThat($rgb->green(), is(0));
        assertThat($rgb->blue(), is(0));
    }

    /** @test */
    public function it_can_change_colors()
    {
        $rgb = new RGB(0, 0, 0);

        $rgb = $rgb->withRed(250);
        $rgb = $rgb->withGreen(150);
        $rgb = $rgb->withBlue(50);

        assertThat($rgb->red(), is(250));
        assertThat($rgb->green(), is(150));
        assertThat($rgb->blue(), is(50));
    }

    /** @test */
    public function it_casts_to_string()
    {
        $rgb = new RGB(12, 34, 56);

        assertThat((string) $rgb, is('12,34,56'));
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hex($hexData, $rgbData, $hslData, $c256Data)
    {
        $rgb = new RGB(...$rgbData);

        $hex = $rgb->toHEX()->withTemplate('# {code}');

        assertThat($hex, is(anInstanceOf(HEX::class)));
        assertThat((string) $hex, is("# {$hexData}"));
    }

    /** @test */
    public function it_can_convert_to_rgb()
    {
        $rgb = new RGB(255, 153, 0);

        $clone = $rgb->toRGB()->withTemplate('{red}, {green}, {blue}');

        assertThat($clone, is(anInstanceOf(RGB::class)));
        assertThat($clone, is(not(sameInstance($rgb))));
        assertThat((string) $clone, is('255, 153, 0'));
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hsl($hexData, $rgbData, $hslData, $c256Data)
    {
        $rgb = new RGB(...$rgbData);

        $hsl = $rgb->toHSL()->withTemplate('{hue}deg {saturation}pct {lightness}pct');

        assertThat($hsl, is(anInstanceOf(HSL::class)));
        assertThat((string) $hsl, is("{$hslData[0]}deg {$hslData[1]}pct {$hslData[2]}pct"));
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_256($hexData, $rgbData, $hslData, $c256Data)
    {
        $rgb = new RGB(...$rgbData);

        $c256 = $rgb->to256()->withTemplate(';{code}');

        assertThat($c256, is(anInstanceOf(C256::class)));
        assertThat((string) $c256, is(";{$c256Data}"));
    }

    /**
     * @return array
     */
    public function colorsDataset()
    {
        return [
            ['hex' => '000000', 'rgb' => [0, 0, 0], 'hsl' => [0, 0, 0], 'c256' => 232],
            ['hex' => 'FFFFFF', 'rgb' => [255, 255, 255], 'hsl' => [0, 0, 100], 'c256' => 255],
            ['hex' => '7F7F7F', 'rgb' => [127, 127, 127], 'hsl' => [0, 0, 50], 'c256' => 243],
            ['hex' => 'FF0000', 'rgb' => [255, 0, 0], 'hsl' => [0, 100, 50], 'c256' => 196],
            ['hex' => '00FF00', 'rgb' => [0, 255, 0], 'hsl' => [120, 100, 50], 'c256' => 46],
            ['hex' => '0000FF', 'rgb' => [0, 0, 255], 'hsl' => [240, 100, 50], 'c256' => 21],
            ['hex' => '00FFFF', 'rgb' => [0, 255, 255], 'hsl' => [180, 100, 50], 'c256' => 51],
            ['hex' => 'FF00FF', 'rgb' => [255, 0, 255], 'hsl' => [300, 100, 50], 'c256' => 201],
            ['hex' => 'FFFF00', 'rgb' => [255, 255, 0], 'hsl' => [60, 100, 50], 'c256' => 226],
            ['hex' => 'FF5F47', 'rgb' => [255, 95, 71], 'hsl' => [8, 100, 64], 'c256' => 209],
            ['hex' => 'FF7565', 'rgb' => [255, 117, 101], 'hsl' => [6, 100, 70], 'c256' => 212],
        ];
    }
}
