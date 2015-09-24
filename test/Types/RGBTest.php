<?php

namespace Tests\Color\Types;

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

    /** @test */
    public function it_can_convert_to_rgb()
    {
        $rgb = new RGB(255, 153, 0);

        $clone = $rgb->toRGB();

        assertThat($clone, is(anInstanceOf(RGB::class)));
        assertThat($clone, is(not(sameInstance($rgb))));
        assertThat((string) $clone, is('255,153,0'));
    }

    /** @test */
    public function it_can_convert_to_hex()
    {
        $rgb = new RGB(255, 153, 0);

        $hex = $rgb->toHEX();

        assertThat($hex, is(anInstanceOf(HEX::class)));
        assertThat((string) $hex, is('#FF9900'));
    }

    /**
     * @test
     * @dataProvider toHslDataset
     */
    public function it_can_convert_to_hsl($rgb, $hsl)
    {
        $rgbObj = new RGB(...$rgb);

        $hslObj = $rgbObj->toHSL();

        assertThat($hslObj, is(anInstanceOf(HSL::class)));
        assertThat((string) $hslObj, is("{$hsl[0]}° {$hsl[1]}% {$hsl[2]}%"));
    }

    /**
     * @return array
     */
    public function toHslDataset()
    {
        return [
            ["rgb" => [0, 0, 0], "hsl" => [0, 0, 0]],
            ["rgb" => [255, 255, 255], "hsl" => [0, 0, 100]],
            ["rgb" => [127, 127, 127], "hsl" => [0, 0, 50]],
            ["rgb" => [255, 0, 0], "hsl" => [0, 100, 50]],
            ["rgb" => [0, 255, 0], "hsl" => [120, 100, 50]],
            ["rgb" => [0, 0, 255], "hsl" => [240, 100, 50]],
            ["rgb" => [0, 255, 255], "hsl" => [180, 100, 50]],
            ["rgb" => [255, 0, 255], "hsl" => [300, 100, 50]],
            ["rgb" => [255, 255, 0], "hsl" => [60, 100, 50]],
            ["rgb" => [255, 95, 71], "hsl" => [8, 100, 64]],
            ["rgb" => [255, 117, 101], "hsl" => [6, 100, 70]],
            ["rgb" => [255, 204, 212], "hsl" => [351, 100, 90]],
        ];
    }
}
