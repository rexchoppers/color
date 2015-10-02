<?php

namespace Color\Types;

use Color\Color;
use Color\Exceptions\InvalidArgument;
use function Color\Helpers\RGBtoC256;
use function Color\Helpers\RGBtoHEX;
use function Color\Helpers\RGBtoHSL;

class RGB implements Color
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
     * @var string
     */
    private $template = '{red},{green},{blue}';

    /**
     * RGB constructor.
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     * @param null|string $template
     *
     * @throws InvalidArgument
     */
    public function __construct($red = 0, $green = 0, $blue = 0, $template = null)
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

        if ($template) {
            $this->template = $template;
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
     * @return array
     */
    public function rgb()
    {
        return [
            $this->red(),
            $this->green(),
            $this->blue(),
        ];
    }

    /**
     * Get a new instance with a new red value.
     *
     * @param int $red
     *
     * @return static
     */
    public function withRed($red)
    {
        return new static($red, $this->green(), $this->blue(), $this->template);
    }

    /**
     * Get a new instance with a new green value.
     *
     * @param int $green
     *
     * @return static
     */
    public function withGreen($green)
    {
        return new static($this->red(), $green, $this->blue(), $this->template);
    }

    /**
     * Get a new instance with a new blue value.
     *
     * @param int $blue
     *
     * @return static
     */
    public function withBlue($blue)
    {
        return new static($this->red(), $this->green(), $blue, $this->template);
    }

    /**
     * Get a new instance with a new template.
     *
     * @param string $template
     *
     * @return static
     */
    public function withTemplate($template)
    {
        return new static($this->red(), $this->green(), $this->blue(), $template);
    }

    /**
     * Get color in HEX.
     *
     * @return HEX
     */
    public function toHEX()
    {
        return new HEX(RGBtoHEX(...$this->rgb()));
    }

    /**
     * Get color in RGB.
     *
     * @return RGB
     */
    public function toRGB()
    {
        return new self(...$this->rgb());
    }

    /**
     * Get color in HSL.
     *
     * @return HSL
     */
    public function toHSL()
    {
        return new HSL(...RGBtoHSL(...$this->rgb()));
    }

    /**
     * Get color in 256.
     *
     * @return C256
     */
    public function to256()
    {
        return new C256(RGBtoC256(...$this->rgb()));
    }

    /**
     * Cast to string.
     *
     * @return string
     */
    public function __toString()
    {
        return str_replace(
            [
                '{red}',
                '{green}',
                '{blue}',
            ],
            [
                $this->red(),
                $this->green(),
                $this->blue(),
            ],
            $this->template
        );
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
