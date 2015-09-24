<?php

namespace Color;

use Color\Types\HEX;
use Color\Types\HSL;
use Color\Types\RGB;

interface Converts
{
    /**
     * Get color in HEX.
     *
     * @return HEX
     */
    public function toHEX();

    /**
     * Get color in RGB.
     *
     * @return RGB
     */
    public function toRGB();

    /**
     * Get color in HSL.
     *
     * @return HSL
     */
    public function toHSL();
}
