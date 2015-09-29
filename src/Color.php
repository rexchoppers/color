<?php

namespace Color;

use Color\Types\HEX;
use Color\Types\HSL;
use Color\Types\RGB;

interface Color
{
    /**
     * Get a new instance with a new template.
     *
     * @param string $template
     *
     * @return static
     */
    public function withTemplate($template);

    /**
     * Cast to string.
     *
     * @return string
     */
    public function __toString();

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

    /**
     * Get color in 256.
     *
     * @return C256
     */
    public function to256();
}
