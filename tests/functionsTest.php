<?php

namespace Scriptura\Color\Tests;

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function Scriptura\Color\Helpers\C256toRGB;
use function Scriptura\Color\Helpers\HSLtoRGB;
use function Scriptura\Color\Helpers\RGBtoC256;

class functionsTest extends TestCase
{
    /** @test */
    public function HSLtoRGB()
    {
        assertEquals([0, 0, 0], HSLtoRGB(0, 0, 0));
        assertEquals([255, 255, 255], HSLtoRGB(0, 0, 100));
        assertEquals([128, 128, 128], HSLtoRGB(0, 0, 50));
        assertEquals([255, 0, 0], HSLtoRGB(0, 100, 50));
        assertEquals([255, 255, 0], HSLtoRGB(60, 100, 50));
        assertEquals([0, 255, 0], HSLtoRGB(120, 100, 50));
        assertEquals([0, 255, 255], HSLtoRGB(180, 100, 50));
        assertEquals([0, 0, 255], HSLtoRGB(240, 100, 50));
        assertEquals([255, 0, 255], HSLtoRGB(300, 100, 50));

        assertEquals([5, 0, 0], HSLtoRGB(0, 100, 1));
        assertEquals([10, 0, 0], HSLtoRGB(0, 100, 2));
        assertEquals([15, 0, 0], HSLtoRGB(0, 100, 3));
        assertEquals([20, 0, 0], HSLtoRGB(0, 100, 4));
    }

    /** @test */
    public function RGBtoC256()
    {
        assertEquals(16, RGBtoC256(0, 0, 0));
        assertEquals(59, RGBtoC256(95, 95, 95));
        assertEquals(102, RGBtoC256(135, 135, 135));
        assertEquals(145, RGBtoC256(175, 175, 175));
        assertEquals(188, RGBtoC256(215, 215, 215));
        assertEquals(231, RGBtoC256(255, 255, 255));

        assertEquals(196, RGBtoC256(255, 0, 0));
        assertEquals(46, RGBtoC256(0, 255, 0));
        assertEquals(21, RGBtoC256(0, 0, 255));
        assertEquals(226, RGBtoC256(255, 255, 0));
        assertEquals(51, RGBtoC256(0, 255, 255));
        assertEquals(201, RGBtoC256(255, 0, 255));
    }

    /** @test */
    public function C256toRGB_primary()
    {
        assertEquals([0, 0, 0], C256toRGB(0));
        assertEquals([128, 0, 0], C256toRGB(1));
        assertEquals([0, 128, 0], C256toRGB(2));
        assertEquals([128, 128, 0], C256toRGB(3));
        assertEquals([0, 0, 128], C256toRGB(4));
        assertEquals([128, 0, 128], C256toRGB(5));
        assertEquals([0, 128, 128], C256toRGB(6));
        assertEquals([192, 192, 192], C256toRGB(7));
    }

    /** @test */
    public function C256toRGB_bright()
    {
        assertEquals([128, 128, 128], C256toRGB(8));
        assertEquals([255, 0, 0], C256toRGB(9));
        assertEquals([0, 255, 0], C256toRGB(10));
        assertEquals([255, 255, 0], C256toRGB(11));
        assertEquals([0, 0, 255], C256toRGB(12));
        assertEquals([255, 0, 255], C256toRGB(13));
        assertEquals([0, 255, 255], C256toRGB(14));
        assertEquals([255, 255, 255], C256toRGB(15));
    }

    /** @test */
    public function C256toRGB_colors()
    {
        assertEquals([0, 0, 0], C256toRGB(16));
        assertEquals([0, 0, 95], C256toRGB(17));
        assertEquals([0, 0, 135], C256toRGB(18));
        assertEquals([0, 0, 175], C256toRGB(19));
        assertEquals([0, 0, 215], C256toRGB(20));
        assertEquals([0, 0, 255], C256toRGB(21));

        assertEquals([0, 95, 0], C256toRGB(22));
        assertEquals([0, 95, 95], C256toRGB(23));
        assertEquals([0, 95, 135], C256toRGB(24));
        assertEquals([0, 95, 175], C256toRGB(25));
        assertEquals([0, 95, 215], C256toRGB(26));
        assertEquals([0, 95, 255], C256toRGB(27));

        assertEquals([0, 255, 0], C256toRGB(46));
        assertEquals([0, 255, 95], C256toRGB(47));
        assertEquals([0, 255, 135], C256toRGB(48));
        assertEquals([0, 255, 175], C256toRGB(49));
        assertEquals([0, 255, 215], C256toRGB(50));
        assertEquals([0, 255, 255], C256toRGB(51));

        assertEquals([95, 0, 0], C256toRGB(52));
        assertEquals([95, 0, 95], C256toRGB(53));
        assertEquals([95, 0, 135], C256toRGB(54));
        assertEquals([95, 0, 175], C256toRGB(55));
        assertEquals([95, 0, 215], C256toRGB(56));
        assertEquals([95, 0, 255], C256toRGB(57));

        assertEquals([255, 255, 0], C256toRGB(226));
        assertEquals([255, 255, 95], C256toRGB(227));
        assertEquals([255, 255, 135], C256toRGB(228));
        assertEquals([255, 255, 175], C256toRGB(229));
        assertEquals([255, 255, 215], C256toRGB(230));
        assertEquals([255, 255, 255], C256toRGB(231));
    }

    /** @test */
    public function C256toRGB_gray()
    {
        assertEquals([8, 8, 8], C256toRGB(232));
        assertEquals([18, 18, 18], C256toRGB(233));
        assertEquals([28, 28, 28], C256toRGB(234));

        assertEquals([218, 218, 218], C256toRGB(253));
        assertEquals([228, 228, 228], C256toRGB(254));
        assertEquals([238, 238, 238], C256toRGB(255));
    }
}
