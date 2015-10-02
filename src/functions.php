<?php

namespace Color\Helpers;

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
 * @param int $red Decimal in range 0-255
 * @param int $green Decimal in range 0-255
 * @param int $blue Decimal in range 0-255
 *
 * @return string
 */
function RGBtoHEX($red, $green, $blue)
{
    return implode('', [
        sprintf('%02x', $red),
        sprintf('%02x', $green),
        sprintf('%02x', $blue),
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
        case ($hue < 60 || $hue === 360):
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
        floor(($rgb[2] + $m) * 255),
    ];
}

/**
 * Get the mix between two hsl colors.
 *
 * http://go.pastie.org/1976031#79-96
 *
 * @param int $hue1 Degree in range 0-360
 * @param int $saturation1 Percent in range 0-100
 * @param int $lightness1 Percent in range 0-100
 * @param int $hue2 Degree in range 0-360
 * @param int $saturation2 Percent in range 0-100
 * @param int $lightness2 Percent in range 0-100
 *
 * @return array [hue(0-360°), saturation(0-100%), lightness(0-100%)]
 */
function mixHSL($hue1, $saturation1, $lightness1, $hue2, $saturation2, $lightness2)
{
    $pi = pi();
    $h1 = $hue1 / 360;
    $s1 = $saturation1 / 100;
    $l1 = $lightness1 / 100;
    $h2 = $hue2 / 360;
    $s2 = $saturation2 / 100;
    $l2 = $lightness2 / 100;

    $h = 0.0;
    $s = 0.5 * ($s1 + $s2);
    $l = 0.5 * ($l1 + $l2);
    $x = cos(2.0 * $pi * $h1) + cos(2.0 * $pi * $h2);
    $y = sin(2.0 * $pi * $h1) + sin(2.0 * $pi * $h2);
    if ($x != 0.0 || $y != 0.0) {
        $h = atan2($y, $x) / (2.0 * $pi);
    } else {
        $s = 0.0;
    }

    $h *= 360;
    $s *= 100;
    $l *= 100;

    if ($h < 0) {
        $h += 360;
    }

    return [$h, $s, $l];
}

/**
 * Converts a color from rgb to 256.
 *
 * https://en.wikipedia.org/wiki/ANSI_escape_code#Colors
 *
 * 0-7:     standard colors
 * 8-15:    high intensity colors
 * 16-231:  6 × 6 × 6 = 216 colors: 16 + 36 × r + 6 × g + b (0 ≤ r, g, b ≤ 5)
 * 232-255: grayscale from black to white in 24 steps
 *
 * @param int $red Decimal in range 0-255
 * @param int $green Decimal in range 0-255
 * @param int $blue Decimal in range 0-255
 *
 * @return int color(0-255)
 */
function RGBtoC256($red, $green, $blue)
{
    if ($red === $green && $green === $blue) {
        return round(232 + $red * 23 / 255);
    } else {
        return round(
            16
            + (($red * 5 / 255) * 36)
            + (($green * 5 / 255) * 6)
            + ($blue * 5 / 255)
        );
    }
}

/**
 * Converts a color from 256 to rgb.
 *
 * https://en.wikipedia.org/wiki/ANSI_escape_code#Colors
 *
 * 0-7:     standard colors
 * 8-15:    high intensity colors
 * 16-231:  6 × 6 × 6 = 216 colors: 16 + 36 × r + 6 × g + b (0 ≤ r, g, b ≤ 5)
 * 232-255: grayscale from black to white in 24 steps
 *
 * @param int $code Decimal in range 0-255
 *
 * @return int [red(0-255), green(0-255), blue(0-255)]
 */
function C256toRGB($code)
{
    // Primary and bright colors
    if ($code == 7) {
        return [192,192,192];
    }
    if ($code == 8) {
        return [128,128,128];
    }
    if ($code >= 0 && 15 >= $code) {
        $value = ($code <= 7) ? 128 : 255;
        $code = ($code <= 7) ? $code : $code - 8;

        $binary = str_pad(decbin($code), 3, '0', STR_PAD_LEFT);
        list($blue, $green, $red) = str_split($binary, 1);

        return [$red * $value, $green * $value, $blue * $value];
    }

    // Colors
    if ($code >= 16 && 231 >= $code) {
        $steps = [0, 95, 135, 175, 215, 255];
        $start = 16;
        $index = $code - $start;

        $red = (int) floor($index / 6 / 6);
        $green = (int) floor($index / 6 % 6);
        $blue = (int) floor($index % 6);

        return [$steps[$red], $steps[$green], $steps[$blue]];
    }

    // Grayscale
    if ($code >= 232 && 255 >= $code) {
        $start = 232;
        $index = $code - $start;

        $color = 8 + $index * 10;

        return [$color, $color, $color];
    }
}
