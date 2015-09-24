<?php

namespace Tests\Color\Types;

use Color\Types\HEX;
use Color\Types\HSL;
use Color\Types\RGB;
use Color\Exceptions\InvalidArgument;

class HSLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider failingDataset
     */
    public function it_fails_with_invalid_range($hue, $saturation, $lightness)
    {
        $this->setExpectedException(InvalidArgument::class);

        $hsl = new HSL($hue, $saturation, $lightness);
    }

    /**
     * @return array
     */
    public function failingDataset()
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

        assertThat($hsl->hue(), is(180));
        assertThat($hsl->saturation(), is(50));
        assertThat($hsl->lightness(), is(50));
    }

    /** @test */
    public function it_defaults_to_black()
    {
        $hsl = new HSL();

        assertThat($hsl->hue(), is(0));
        assertThat($hsl->saturation(), is(0));
        assertThat($hsl->lightness(), is(0));
    }

    /** @test */
    public function it_can_change_colors()
    {
        $hsl = new HSL(0, 0, 0);

        $hsl = $hsl->withHue(90);
        $hsl = $hsl->withSaturation(75);
        $hsl = $hsl->withLightness(25);

        assertThat($hsl->hue(), is(90));
        assertThat($hsl->saturation(), is(75));
        assertThat($hsl->lightness(), is(25));
    }

    /** @test */
    public function it_casts_to_string()
    {
        $hsl = new HSL(0, 100, 50);

        assertThat((string) $hsl, is('0° 100% 50%'));
    }

    /** @test */
    public function it_can_convert_to_hsl()
    {
        $hsl = new HSL(0, 100, 50);

        $clone = $hsl->toHSL();

        assertThat($clone, is(anInstanceOf(HSL::class)));
        assertThat($clone, is(not(sameInstance($hsl))));
        assertThat((string) $clone, is('0° 100% 50%'));
    }

//    /** @test */
//    public function it_can_convert_to_hex()
//    {
//        $rgb = new HSL(0, 100, 50);
//
//        $hex = $rgb->toHEX();
//
//        assertThat($hex, is(anInstanceOf(HEX::class)));
//        assertThat((string) $hex, is('#FF0000'));
//    }

    /**
     * @test
     * @dataProvider toRgbDataset
     */
    public function it_can_convert_to_rgb($rgb, $hsl)
    {
        $hslObj = new HSL(...$hsl);

        $rgbObj = $hslObj->toRGB();

        assertThat($rgbObj, is(anInstanceOf(RGB::class)));
        assertThat((string) $rgbObj, is("{$rgb[0]},{$rgb[1]},{$rgb[2]}"));
    }

    /**
     * @return array
     */
    public function toRgbDataset()
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
