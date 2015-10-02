<?php

namespace Tests\ConvertColor;

use function Color\Helpers\C256toRGB;

class functionsTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function C256toRGB_primary()
    {
        assertThat(C256toRGB(0), is([0, 0, 0]));
        assertThat(C256toRGB(1), is([128, 0, 0]));
        assertThat(C256toRGB(2), is([0, 128, 0]));
        assertThat(C256toRGB(3), is([128, 128, 0]));
        assertThat(C256toRGB(4), is([0, 0, 128]));
        assertThat(C256toRGB(5), is([128, 0, 128]));
        assertThat(C256toRGB(6), is([0, 128, 128]));
        assertThat(C256toRGB(7), is([192, 192, 192]));
    }

    /** @test */
    public function C256toRGB_bright()
    {
        assertThat(C256toRGB(8), is([128, 128, 128]));
        assertThat(C256toRGB(9), is([255, 0, 0]));
        assertThat(C256toRGB(10), is([0, 255, 0]));
        assertThat(C256toRGB(11), is([255, 255, 0]));
        assertThat(C256toRGB(12), is([0, 0, 255]));
        assertThat(C256toRGB(13), is([255, 0, 255]));
        assertThat(C256toRGB(14), is([0, 255, 255]));
        assertThat(C256toRGB(15), is([255, 255, 255]));
    }

    /** @test */
    public function C256toRGB_colors()
    {
        assertThat(C256toRGB(16), is([0, 0, 0]));
        assertThat(C256toRGB(17), is([0, 0, 95]));
        assertThat(C256toRGB(18), is([0, 0, 135]));
        assertThat(C256toRGB(19), is([0, 0, 175]));
        assertThat(C256toRGB(20), is([0, 0, 215]));
        assertThat(C256toRGB(21), is([0, 0, 255]));

        assertThat(C256toRGB(22), is([0, 95, 0]));
        assertThat(C256toRGB(23), is([0, 95, 95]));
        assertThat(C256toRGB(24), is([0, 95, 135]));
        assertThat(C256toRGB(25), is([0, 95, 175]));
        assertThat(C256toRGB(26), is([0, 95, 215]));
        assertThat(C256toRGB(27), is([0, 95, 255]));

        assertThat(C256toRGB(46), is([0, 255, 0]));
        assertThat(C256toRGB(47), is([0, 255, 95]));
        assertThat(C256toRGB(48), is([0, 255, 135]));
        assertThat(C256toRGB(49), is([0, 255, 175]));
        assertThat(C256toRGB(50), is([0, 255, 215]));
        assertThat(C256toRGB(51), is([0, 255, 255]));

        assertThat(C256toRGB(52), is([95, 0, 0]));
        assertThat(C256toRGB(53), is([95, 0, 95]));
        assertThat(C256toRGB(54), is([95, 0, 135]));
        assertThat(C256toRGB(55), is([95, 0, 175]));
        assertThat(C256toRGB(56), is([95, 0, 215]));
        assertThat(C256toRGB(57), is([95, 0, 255]));

        assertThat(C256toRGB(226), is([255, 255, 0]));
        assertThat(C256toRGB(227), is([255, 255, 95]));
        assertThat(C256toRGB(228), is([255, 255, 135]));
        assertThat(C256toRGB(229), is([255, 255, 175]));
        assertThat(C256toRGB(230), is([255, 255, 215]));
        assertThat(C256toRGB(231), is([255, 255, 255]));
    }

    /** @test */
    public function C256toRGB_gray()
    {
        assertThat(C256toRGB(232), is([8, 8, 8]));
        assertThat(C256toRGB(233), is([18, 18, 18]));
        assertThat(C256toRGB(234), is([28, 28, 28]));

        assertThat(C256toRGB(253), is([218, 218, 218]));
        assertThat(C256toRGB(254), is([228, 228, 228]));
        assertThat(C256toRGB(255), is([238, 238, 238]));
    }
}
