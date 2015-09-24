<?php

namespace Color\Types;

use Color\Converts;
use Color\Type;
use Color\Exceptions\InvalidArgument;

class RGB implements Type, Converts
{
    /**
     * @var int (0-255)
     */
    private $red;

    /**
     * @var int (0-255)
     */
    private $green;

    /**
     * @var int (0-255)
     */
    private $blue;

    /**
     * Get the key for this type, used to access the type from the color object.
     *
     * @return string
     */
    public static function key()
    {
        return 'rgb';
    }

    /**
     * RGB constructor.
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     *
     * @throws InvalidArgument
     */
    public function __construct($red = 0, $green = 0, $blue = 0)
    {
        if ( ! $this->isDecimal($red)) {
            throw new InvalidArgument("Decimal (0-255) value was expected but [{$red}] was given.");
        }
        if ( ! $this->isDecimal($green)) {
            throw new InvalidArgument("Decimal (0-255) value was expected but [{$green}] was given.");
        }
        if ( ! $this->isDecimal($blue)) {
            throw new InvalidArgument("Decimal (0-255) value was expected but [{$blue}] was given.");
        }

        $this->red = (int) $red;
        $this->green = (int) $green;
        $this->blue = (int) $blue;
    }

    /**
     * @return int
     */
    public function red()
    {
        return $this->red;
    }

    /**
     * @return int
     */
    public function green()
    {
        return $this->green;
    }

    /**
     * @return int
     */
    public function blue()
    {
        return $this->blue;
    }

    /**
     * @param int $red
     *
     * @return static
     */
    public function withRed($red)
    {
        return new static($red, $this->green, $this->blue);
    }

    /**
     * @param int $green
     *
     * @return static
     */
    public function withGreen($green)
    {
        return new static($this->red, $green, $this->blue);
    }

    /**
     * @param int $blue
     *
     * @return static
     */
    public function withBlue($blue)
    {
        return new static($this->red, $this->green, $blue);
    }

    /**
     * Get color in HEX.
     *
     * @return HEX
     */
    public function toHEX()
    {
        return new HEX(join('', [
            sprintf('%02x', $this->red),
            sprintf('%02x', $this->green),
            sprintf('%02x', $this->blue)
        ]));
    }

    /**
     * Get color in RGB.
     *
     * @return RGB
     */
    public function toRGB()
    {
        return clone $this;
    }

    /**
     * Get color in HSL.
     *
     * http://www.rapidtables.com/convert/color/rgb-to-hsl.htm
     *
     * 0 ≤ $red ≤ 1
     * 0 ≤ $green ≤ 1
     * 0 ≤ $blue ≤ 1
     *
     * $c = Chroma
     *
     * @return HSL
     */
    public function toHSL()
    {
        $red = $this->red / 255;
        $green = $this->green / 255;
        $blue = $this->blue / 255;

        $min = min($red, $green, $blue);
        $max = max($red, $green, $blue);
        $c = $max - $min;

        $lightness = ($max + $min) / 2;

        if ($c == 0) {
            $hue = 0;
            $saturation = 0;
        } else {
            switch (true) {
                case ($max === $red):
                    $hue = (($green - $blue) / $c);
                    break;
                case ($max === $green):
                    $hue = (($blue - $red) / $c) + 2;
                    break;
                case ($max === $blue):
                    $hue = (($red - $green) / $c) + 4;
                    break;
            }

            $hue *= 60;

            if ($hue < 0) {
                $hue += 360;
            }


            if ($lightness > 0.5) {
                $saturation = $c / (2 - $max - $min);
            } else {
                $saturation = $c / ($max + $min);
            }


//            $saturation = $c / (1 - abs(2 * $lightness - 1));
        }

        $hue = round($hue, 0);
        $saturation = round($saturation * 100, 0);
        $lightness = round($lightness * 100, 0);

        return new HSL($hue, $saturation, $lightness);
    }

    /**
     * Cast to string.
     *
     * @return string
     */
    public function __toString()
    {
        return "{$this->red},{$this->green},{$this->blue}";
    }

    /**
     * @param int $value
     *
     * @return bool
     */
    private function isDecimal($value)
    {
        if ($value >= 0 && $value <= 255) {
            return true;
        }

        return false;
    }
}
