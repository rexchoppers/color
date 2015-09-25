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

        $clone = $hsl->toHSL()->withTemplate('{hue}deg {saturation}pct {lightness}pct');

        assertThat($clone, is(anInstanceOf(HSL::class)));
        assertThat($clone, is(not(sameInstance($hsl))));
        assertThat((string) $clone, is('0deg 100pct 50pct'));
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hex($hexData, $rgbData, $hslData)
    {
        $hsl = new HSL(...$hslData);

        $hex = $hsl->toHEX()->withTemplate('# {code}');

        assertThat($hex, is(anInstanceOf(HEX::class)));
        assertThat((string) $hex, is("# {$hexData}"));
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_rgb($hexData, $rgbData, $hslData)
    {
        $hsl = new HSL(...$hslData);

        $rgb = $hsl->toRGB()->withTemplate('{red}, {green}, {blue}');

        assertThat($rgb, is(anInstanceOf(RGB::class)));
        assertThat((string) $rgb, is("{$rgbData[0]}, {$rgbData[1]}, {$rgbData[2]}"));
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

    /** @test */
    public function it_can_lighten_a_color()
    {
        $hsl = new HSL(0, 100, 25, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->lighten(25);

        assertThat((string) $hsl, is('0deg 100pct 50pct'));
    }

    /** @test */
    public function it_limits_lightness_to_100_when_lightening()
    {
        $hsl = new HSL(0, 100, 90, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->lighten(11);

        assertThat((string) $hsl, is('0deg 100pct 100pct'));
    }

    /** @test */
    public function it_can_darken_a_color()
    {
        $hsl = new HSL(0, 100, 50, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->darken(25);

        assertThat((string) $hsl, is('0deg 100pct 25pct'));
    }

    /** @test */
    public function it_limits_lightness_to_0_when_darkenening()
    {
        $hsl = new HSL(0, 100, 10, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->darken(11);

        assertThat((string) $hsl, is('0deg 100pct 0pct'));
    }

    /** @test */
    public function it_can_saturate_a_color()
    {
        $hsl = new HSL(0, 25, 50, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->saturate(25);

        assertThat((string) $hsl, is('0deg 50pct 50pct'));
    }

    /** @test */
    public function it_limits_saturation_to_100_when_saturating()
    {
        $hsl = new HSL(0, 90, 50, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->saturate(11);

        assertThat((string) $hsl, is('0deg 100pct 50pct'));
    }

    /** @test */
    public function it_can_desaturate_a_color()
    {
        $hsl = new HSL(0, 50, 50, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->desaturate(25);

        assertThat((string) $hsl, is('0deg 25pct 50pct'));
    }

    /** @test */
    public function it_limits_saturation_to_0_when_desaturating()
    {
        $hsl = new HSL(0, 10, 50, '{hue}deg {saturation}pct {lightness}pct');

        $hsl = $hsl->desaturate(11);

        assertThat((string) $hsl, is('0deg 0pct 50pct'));
    }
}
