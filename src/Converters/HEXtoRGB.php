<?php

namespace Color\Converters;

use Color\Types\HEX;
use Color\Types\RGB;

class HEXtoRGB
{
    public function convert(HEX $hex)
    {
        $rgb = array_map('hexdec',str_split($hex->code(), 2));

        return new RGB(...$rgb);
    }
}
