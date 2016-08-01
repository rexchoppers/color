<?php

require_once 'vendor/autoload.php';

echo "\n##### HEX ('ff0000') #####\n";
$hex = new \Scriptura\Color\Types\HEX('ff0000');
$hex = new \Scriptura\Color\Types\HEX('ff0000', '#{code}');
echo "Code:           " . $hex->code() . "\n";
echo "(string):       " . $hex . "\n";
echo "Template:       " . $hex->withTemplate('color: #{code};') . "\n";

echo "toHEX:          " . $hex->toHEX() . "\n";
echo "toRGB:          " . $hex->toRGB() . "\n";
echo "toHSL:          " . $hex->toHSL() . "\n";
echo "to256:          " . $hex->to256() . "\n";


echo "\n##### RGB (255, 0, 0) #####\n";
$rgb = new \Scriptura\Color\Types\RGB(255, 0, 0);
$rgb = new \Scriptura\Color\Types\RGB(255, 0, 0, '{red},{green},{blue}');
echo "Red:            " . $rgb->red() . "\n";
echo "Green:          " . $rgb->green() . "\n";
echo "Blue:           " . $rgb->blue() . "\n";
echo "Array:          " . implode(',', $rgb->rgb()) . "\n";
echo "(string):       " . $rgb . "\n";
echo "Template:       " . $rgb->withTemplate('color: rgb({red}, {green}, {blue});') . "\n";

echo "withRed:        " . $rgb->withRed(0) . "\n";
echo "withGreen:      " . $rgb->withGreen(255) . "\n";
echo "withBlue:       " . $rgb->withBlue(255) . "\n";

echo "toHEX:          " . $rgb->toHEX() . "\n";
echo "toRGB:          " . $rgb->toRGB() . "\n";
echo "toHSL:          " . $rgb->toHSL() . "\n";
echo "to256:          " . $rgb->to256() . "\n";


echo "\n##### HSL (0, 100, 50) #####\n";
$hsl = new \Scriptura\Color\Types\HSL(0, 100, 50);
$hsl = new \Scriptura\Color\Types\HSL(0, 100, 50, '{hue}° {saturation}% {lightness}%');
echo "Hue:            " . $hsl->hue() . "\n";
echo "Saturation:     " . $hsl->saturation() . "\n";
echo "Lightness:      " . $hsl->lightness() . "\n";
echo "Array:          " . implode(',', $hsl->hsl()) . "\n";
echo "(string):       " . $hsl . "\n";
echo "Template:       " . $hsl->withTemplate('color: ({hue}, {saturation}%, {lightness}%);') . "\n";

echo "withHue:        " . $hsl->withHue(180) . "\n";
echo "withSaturation: " . $hsl->withSaturation(50) . "\n";
echo "withLightness:  " . $hsl->withLightness(25) . "\n";

echo "toHEX:          " . $hsl->toHEX() . "\n";
echo "toRGB:          " . $hsl->toRGB() . "\n";
echo "toHSL:          " . $hsl->toHSL() . "\n";
echo "to256:          " . $hsl->to256() . "\n";

echo "Lighten:        " . $hsl->lighten(10) . "\n";
echo "Darken:         " . $hsl->darken(10) . "\n";

echo "Saturate:       " . $hsl->saturate(10) . "\n";
echo "Desaturate:     " . $hsl->desaturate(10) . "\n";

echo "Mix:            " . $mix = $hsl->mix(new \Scriptura\Color\Types\HSL(120, 25, 25)) . "\n";


echo "\n##### 256 (196) #####\n";
$c256 = new \Scriptura\Color\Types\C256(196);
$c256 = new \Scriptura\Color\Types\C256(196, '{code}');
echo "Code:           " . $c256->code() . "\n";
echo "(string):       " . $c256 . "\n";
echo "Template:       " . $c256->withTemplate('\e[48;{code}m') . "\n";

echo "toHEX:          " . $c256->toHEX() . "\n";
echo "toRGB:          " . $c256->toRGB() . "\n";
echo "toHSL:          " . $c256->toHSL() . "\n";
echo "to256:          " . $c256->to256() . "\n";

