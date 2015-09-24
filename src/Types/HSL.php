<?php

namespace Color\Types;

use Color\Converts;
use Color\Type;
use Color\Exceptions\InvalidArgument;

class HSL implements Type, Converts
{
    /**
     * @var float (0-360)
     */
    private $hue;

    /**
     * @var float (0-100)
     */
    private $saturation;

    /**
     * @var float (0-100)
     */
    private $lightness;

    /**
     * Get the key for this type, used to access the type from the color object.
     *
     * @return string
     */
    public static function key()
    {
        return 'hsl';
    }

    /**
     * HSL constructor.
     *
     * @param float $hue
     * @param float $saturation
     * @param float $lightness
     *
     * @throws InvalidArgument
     */
    public function __construct($hue = 0.0, $saturation = 0.0, $lightness = 0.0)
    {
        if ( ! $this->isDegree($hue)) {
            throw new InvalidArgument("Degree (0-360) value was expected but [{$hue}] was given.");
        }
        if ( ! $this->isPercent($saturation)) {
            throw new InvalidArgument("Percent (0-100) value was expected but [{$saturation}] was given.");
        }
        if ( ! $this->isPercent($lightness)) {
            throw new InvalidArgument("Percent (0-100) value was expected but [{$lightness}] was given.");
        }

        $this->hue = (float) $hue;
        $this->saturation = (float) $saturation;
        $this->lightness = (float) $lightness;
    }

    /**
     * Convert current type to another type.
     *
     * @param Type $type
     *
     * @return Type
     */
    public function to(Type $type)
    {
        // TODO: Implement to() method.
    }

    /**
     * @return float
     */
    public function hue()
    {
        return $this->hue;
    }

    /**
     * @return float
     */
    public function saturation()
    {
        return $this->saturation;
    }

    /**
     * @return float
     */
    public function lightness()
    {
        return $this->lightness;
    }

    /**
     * @param float $hue
     *
     * @return static
     */
    public function withHue($hue)
    {
        return new static($hue, $this->saturation, $this->lightness);
    }

    /**
     * @param float $saturation
     *
     * @return static
     */
    public function withSaturation($saturation)
    {
        return new static($this->hue, $saturation, $this->lightness);
    }

    /**
     * @param float $lightness
     *
     * @return static
     */
    public function withLightness($lightness)
    {
        return new static($this->hue, $this->saturation, $lightness);
    }

    /**
     * Get color in HEX.
     *
     * @return HEX
     */
    public function toHEX()
    {
        return new HEX();
    }

    /**
     * Get color in RGB.
     *
     * http://www.rapidtables.com/convert/color/hsl-to-rgb.htm
     *
     * Maybe: http://stackoverflow.com/questions/4784040/rgb-to-hsl-hue-calculation-is-wrong?rq=1
     *
     * 0 ≤ $hue < 360
     * 0 ≤ $saturation ≤ 1
     * 0 ≤ $lightness ≤ 1
     *
     * $c = Chroma
     * $x = Second largest component of this color
     * $m = Amount to add to match lightness
     *
     * @return RGB
     */
    public function toRGB()
    {
        $hue = $this->hue;
        $saturation = $this->saturation / 100;
        $lightness = $this->lightness / 100;

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

        $rgb = [
            floor(($rgb[0] + $m) * 255),
            floor(($rgb[1] + $m) * 255),
            floor(($rgb[2] + $m) * 255)
        ];

        return new RGB(...$rgb);
    }

    /**
     * Get color in HSL.
     *
     * @return HSL
     */
    public function toHSL()
    {
        return clone $this;
    }

    /**
     * Cast to string.
     *
     * @return string
     */
    public function __toString()
    {
        return "{$this->hue}° {$this->saturation}% {$this->lightness}%";
    }

    /**
     * @param float $value
     *
     * @return bool
     */
    private function isDegree($value)
    {
        if ($value >= 0 && $value <= 360) {
            return true;
        }

        return false;
    }

    /**
     * @param float $value
     *
     * @return bool
     */
    private function isPercent($value)
    {
        if ($value >= 0 && $value <= 100) {
            return true;
        }

        return false;
    }
}
