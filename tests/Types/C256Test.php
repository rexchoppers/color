<?php

namespace Scriptura\Color\Tests\Types;

use Scriptura\Color\Types\C256;
use Scriptura\Color\Types\HEX;
use Scriptura\Color\Types\HSL;
use Scriptura\Color\Types\RGB;
use Scriptura\Color\Exceptions\InvalidArgument;

class C256Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider failingDataset
     */
    public function it_fails_with_invalid_code($code)
    {
        $this->setExpectedException(InvalidArgument::class);

        $c256 = new C256($code);
    }

    /**
     * @return array
     */
    public function failingDataset()
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

        assertThat($c256->code(), is(51));
    }

    /** @test */
    public function it_defaults_to_black()
    {
        $c256 = new C256();

        assertThat($c256->code(), is(232));
    }

    /** @test */
    public function it_casts_to_string()
    {
        $c256 = new C256(232);

        assertThat((string) $c256, is('232'));
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hex($c256Data, $hexData, $rgbData, $hslData)
    {
        $c256 = new C256($c256Data);

        $hex = $c256->toHEX()->withTemplate('# {code}');

        assertThat($hex, is(anInstanceOf(HEX::class)));
        assertThat((string) $hex, is("# {$hexData}"));
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_rgb($c256Data, $hexData, $rgbData, $hslData)
    {
        $c256 = new C256($c256Data);

        $rgb = $c256->toRGB()->withTemplate('{red}, {green}, {blue}');

        assertThat($rgb, is(anInstanceOf(RGB::class)));
        assertThat((string) $rgb, is("{$rgbData[0]}, {$rgbData[1]}, {$rgbData[2]}"));
    }

    /**
     * @test
     * @dataProvider colorsDataset
     */
    public function it_can_convert_to_hsl($c256Data, $hexData, $rgbData, $hslData)
    {
        $c256 = new C256($c256Data);

        $hsl = $c256->toHSL()->withTemplate('{hue}deg {saturation}pct {lightness}pct');

        assertThat($hsl, is(anInstanceOf(HSL::class)));
        assertThat((string) $hsl, is("{$hslData[0]}deg {$hslData[1]}pct {$hslData[2]}pct"));
    }

    /** @test */
    public function it_can_convert_to_256()
    {
        $c256 = new C256(16);

        $clone = $c256->to256()->withTemplate(';{code}');

        assertThat($clone, is(anInstanceOf(C256::class)));
        assertThat($clone, is(not(sameInstance($c256))));
        assertThat((string) $clone, is(';16'));
    }

    /**
     * @return array
     */
    public function colorsDataset()
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
