<?php

namespace Tests\Color;

use Color\Color;
use Color\Types\HEX;
use Color\Types\RGB;

class ColorTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_access_color_in_any_type()
    {
        $color = new Color(new RGB(255, 0, 0));

//        assertThat($color->hex, is(anInstanceOf(HEX::class)));
//        assertThat($color->hex->code(), is('F00000'));
//        assertThat($color->rgb->red(), is(250));
//        assertThat($color->hsl->hue(), is(180));
    }

//    /** @test */
//    public function it_can_access_color_in_any_type()
//    {
//        $color = new Color(new RGB(255, 0, 0));
//
//        assertThat($color->rgb->red(), is(255));
//        assertThat($color->hsl->hue(), is(180));
//        assertThat($color->hex->code(), is('FF0000'));
//    }
}
