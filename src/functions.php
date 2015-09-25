<?php

namespace ConvertColor;

/**
 * Converts a color from hex to rgb.
 *
 * eg.
 * 'FF5F47' => [255, 95, 71]
 *
 * @param string $code Hex code without #
 *
 * @return array [red(0-255), green(0-255), blue(0-255)]
 */
function HEXtoRGB($code)
{
    return array_map('hexdec', str_split($code, 2));
}

/**
 * Converts a color from rgb to hex.
 *
 * eg.
 * [255, 95, 71] => 'FF5F47'
 *
 * @param integer $red Decimal in range 0-255
 * @param integer $green Decimal in range 0-255
 * @param integer $blue Decimal in range 0-255
 *
 * @return string
 */
function RGBtoHEX($red, $green, $blue)
{
    return join('', [
        sprintf('%02x', $red),
        sprintf('%02x', $green),
        sprintf('%02x', $blue)
    ]);
}

/**
 * Converts a color from rgb to hsl.
 *
 * eg.
 * [255, 95, 71] => [8, 100, 64]
 *
 * http://www.rapidtables.com/convert/color/rgb-to-hsl.htm
 *
 * $min = Smallest part of the color
 * $max = Largest part of the color
 * $c = Chroma
 *
 * @param int $red Decimal in range 0-255
 * @param int $green Decimal in range 0-255
 * @param int $blue Decimal in range 0-255
 *
 * @return array [hue(0-360°), saturation(0-100%), lightness(0-100%)]
 */
function RGBtoHSL($red, $green, $blue)
{
    $red /= 255;
    $green /= 255;
    $blue /= 255;

    $min = min($red, $green, $blue);
    $max = max($red, $green, $blue);
    $c = $max - $min;

    $hue = 0;
    $saturation = 0;
    $lightness = ($max + $min) / 2;

    if ($c != 0) {
        switch ($max) {
            case $red:
                $hue = fmod(($green - $blue) / $c, 6);
                break;
            case $green:
                $hue = (($blue - $red) / $c) + 2;
                break;
            case $blue:
                $hue = (($red - $green) / $c) + 4;
                break;
        }

        $hue *= 60;

        if ($hue < 0) {
            $hue += 360;
        }

        $saturation = $c / (1 - abs(2 * $lightness - 1));
    }

    return [
        round($hue, 0),
        round($saturation * 100, 0),
        round($lightness * 100, 0),
    ];
}

/**
 * Converts a color from hsl to rgb.
 *
 * eg.
 * [8, 100, 64] => [255, 95, 71]
 *
 * http://www.rapidtables.com/convert/color/hsl-to-rgb.htm
 *
 * $c = Chroma
 * $x = Second largest component of this color
 * $m = Amount to add to match lightness
 *
 * @param int $hue Degree in range 0-360
 * @param int $saturation Percent in range 0-100
 * @param int $lightness Percent in range 0-100
 *
 * @return array [red(0-255), green(0-255), blue(0-255)]
 */
function HSLtoRGB($hue, $saturation, $lightness)
{
    $saturation /= 100;
    $lightness /= 100;

    $c = (1 - abs(2 * $lightness - 1)) * $saturation;
    $x = $c * (1 - abs(fmod(($hue / 60), 2) - 1));
    $m = $lightness - ($c / 2);

    switch (true) {
        case ($hue < 60):
            $rgb = [$c, $x, 0];
            break;
        case ($hue < 120):
            $rgb = [$x, $c, 0];
            break;
        case ($hue < 180):
            $rgb = [0, $c, $x];
            break;
        case ($hue < 240):
            $rgb = [0, $x, $c];
            break;
        case ($hue < 300):
            $rgb = [$x, 0, $c];
            break;
        case ($hue < 360):
            $rgb = [$c, 0, $x];
            break;
    }

    return [
        floor(($rgb[0] + $m) * 255),
        floor(($rgb[1] + $m) * 255),
        floor(($rgb[2] + $m) * 255)
    ];
}
