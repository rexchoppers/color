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
        assertEquals(HSLtoRGB(0, 0, 0), [0, 0, 0]);
        assertEquals(HSLtoRGB(0, 0, 100), [255, 255, 255]);
        assertEquals(HSLtoRGB(0, 0, 50), [128, 128, 128]);
        assertEquals(HSLtoRGB(0, 100, 50), [255, 0, 0]);
        assertEquals(HSLtoRGB(60, 100, 50), [255, 255, 0]);
        assertEquals(HSLtoRGB(120, 100, 50), [0, 255, 0]);
        assertEquals(HSLtoRGB(180, 100, 50), [0, 255, 255]);
        assertEquals(HSLtoRGB(240, 100, 50), [0, 0, 255]);
        assertEquals(HSLtoRGB(300, 100, 50), [255, 0, 255]);

        assertEquals(HSLtoRGB(0, 100, 1), [5, 0, 0]);
        assertEquals(HSLtoRGB(0, 100, 2), [10, 0, 0]);
        assertEquals(HSLtoRGB(0, 100, 3), [15, 0, 0]);
        assertEquals(HSLtoRGB(0, 100, 4), [20, 0, 0]);
    }

    /** @test */
    public function RGBtoC256()
    {
        assertEquals(RGBtoC256(0, 0, 0), 16);
        assertEquals(RGBtoC256(95, 95, 95), 59);
        assertEquals(RGBtoC256(135, 135, 135), 102);
        assertEquals(RGBtoC256(175, 175, 175), 145);
        assertEquals(RGBtoC256(215, 215, 215), 188);
        assertEquals(RGBtoC256(255, 255, 255), 231);

        assertEquals(RGBtoC256(255, 0, 0), 196);
        assertEquals(RGBtoC256(0, 255, 0), 46);
        assertEquals(RGBtoC256(0, 0, 255), 21);
        assertEquals(RGBtoC256(255, 255, 0), 226);
        assertEquals(RGBtoC256(0, 255, 255), 51);
        assertEquals(RGBtoC256(255, 0, 255), 201);
    }

    /** @test */
    public function C256toRGB_primary()
    {
        assertEquals(C256toRGB(0), [0, 0, 0]);
        assertEquals(C256toRGB(1), [128, 0, 0]);
        assertEquals(C256toRGB(2), [0, 128, 0]);
        assertEquals(C256toRGB(3), [128, 128, 0]);
        assertEquals(C256toRGB(4), [0, 0, 128]);
        assertEquals(C256toRGB(5), [128, 0, 128]);
        assertEquals(C256toRGB(6), [0, 128, 128]);
        assertEquals(C256toRGB(7), [192, 192, 192]);
    }

    /** @test */
    public function C256toRGB_bright()
    {
        assertEquals(C256toRGB(8), [128, 128, 128]);
        assertEquals(C256toRGB(9), [255, 0, 0]);
        assertEquals(C256toRGB(10), [0, 255, 0]);
        assertEquals(C256toRGB(11), [255, 255, 0]);
        assertEquals(C256toRGB(12), [0, 0, 255]);
        assertEquals(C256toRGB(13), [255, 0, 255]);
        assertEquals(C256toRGB(14), [0, 255, 255]);
        assertEquals(C256toRGB(15), [255, 255, 255]);
    }

    /** @test */
    public function C256toRGB_colors()
    {
        assertEquals(C256toRGB(16), [0, 0, 0]);
        assertEquals(C256toRGB(17), [0, 0, 95]);
        assertEquals(C256toRGB(18), [0, 0, 135]);
        assertEquals(C256toRGB(19), [0, 0, 175]);
        assertEquals(C256toRGB(20), [0, 0, 215]);
        assertEquals(C256toRGB(21), [0, 0, 255]);

        assertEquals(C256toRGB(22), [0, 95, 0]);
        assertEquals(C256toRGB(23), [0, 95, 95]);
        assertEquals(C256toRGB(24), [0, 95, 135]);
        assertEquals(C256toRGB(25), [0, 95, 175]);
        assertEquals(C256toRGB(26), [0, 95, 215]);
        assertEquals(C256toRGB(27), [0, 95, 255]);

        assertEquals(C256toRGB(46), [0, 255, 0]);
        assertEquals(C256toRGB(47), [0, 255, 95]);
        assertEquals(C256toRGB(48), [0, 255, 135]);
        assertEquals(C256toRGB(49), [0, 255, 175]);
        assertEquals(C256toRGB(50), [0, 255, 215]);
        assertEquals(C256toRGB(51), [0, 255, 255]);

        assertEquals(C256toRGB(52), [95, 0, 0]);
        assertEquals(C256toRGB(53), [95, 0, 95]);
        assertEquals(C256toRGB(54), [95, 0, 135]);
        assertEquals(C256toRGB(55), [95, 0, 175]);
        assertEquals(C256toRGB(56), [95, 0, 215]);
        assertEquals(C256toRGB(57), [95, 0, 255]);

        assertEquals(C256toRGB(226), [255, 255, 0]);
        assertEquals(C256toRGB(227), [255, 255, 95]);
        assertEquals(C256toRGB(228), [255, 255, 135]);
        assertEquals(C256toRGB(229), [255, 255, 175]);
        assertEquals(C256toRGB(230), [255, 255, 215]);
        assertEquals(C256toRGB(231), [255, 255, 255]);
    }

    /** @test */
    public function C256toRGB_gray()
    {
        assertEquals(C256toRGB(232), [8, 8, 8]);
        assertEquals(C256toRGB(233), [18, 18, 18]);
        assertEquals(C256toRGB(234), [28, 28, 28]);

        assertEquals(C256toRGB(253), [218, 218, 218]);
        assertEquals(C256toRGB(254), [228, 228, 228]);
        assertEquals(C256toRGB(255), [238, 238, 238]);
    }
}
