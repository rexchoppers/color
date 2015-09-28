<?php

namespace Color\Types;

use Color\Color;
use Color\Exceptions\InvalidArgument;
use function ConvertColor\HSLtoRGB;
use function ConvertColor\RGBtoHEX;
use function ConvertColor\mixHSL;

class HSL implements Color
{
    /**
     * @var int (0-360)
     */
    private $hue;

    /**
     * @var int (0-100)
     */
    private $saturation;

    /**
     * @var int (0-100)
     */
    private $lightness;

    /**
     * @var string
     */
    private $template = '{hue}° {saturation}% {lightness}%';

    /**
     * HSL constructor.
     *
     * @param int $hue
     * @param int $saturation
     * @param int $lightness
     * @param null|string $template
     *
     * @throws InvalidArgument
     */
    public function __construct($hue = 0, $saturation = 0, $lightness = 0, $template = null)
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

        if ($template) {
            $this->template = $template;
        }

        $this->hue = (int) $hue;
        $this->saturation = (int) $saturation;
        $this->lightness = (int) $lightness;
    }

    /**
     * @return int
     */
    public function hue()
    {
        return $this->hue;
    }

    /**
     * @return int
     */
    public function saturation()
    {
        return $this->saturation;
    }

    /**
     * @return int
     */
    public function lightness()
    {
        return $this->lightness;
    }

    /**
     * @return array
     */
    public function hsl()
    {
        return [
            $this->hue(),
            $this->saturation(),
            $this->lightness(),
        ];
    }

    /**
     * Get a new instance with a new hue value.
     *
     * @param int $hue
     *
     * @return static
     */
    public function withHue($hue)
    {
        return new static($hue, $this->saturation(), $this->lightness(), $this->template);
    }

    /**
     * Get a new instance with a new saturation value.
     *
     * @param int $saturation
     *
     * @return static
     */
    public function withSaturation($saturation)
    {
        return new static($this->hue(), $saturation, $this->lightness(), $this->template);
    }

    /**
     * Get a new instance with a new lightness value.
     *
     * @param int $lightness
     *
     * @return static
     */
    public function withLightness($lightness)
    {
        return new static($this->hue(), $this->saturation(), $lightness, $this->template);
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
        return new static($this->hue(), $this->saturation(), $this->lightness(), $template);
    }

    /**
     * Lighten the color.
     *
     * @param int $pct
     *
     * @return static
     */
    public function lighten($pct)
    {
        $lightness = $this->lightness() + $pct;
        $lightness = $lightness > 100 ? 100 : $lightness;

        return $this->withLightness($lightness);
    }

    /**
     * Darken the color.
     *
     * @param int $pct
     *
     * @return static
     */
    public function darken($pct)
    {
        $lightness = $this->lightness() - $pct;
        $lightness = $lightness < 0 ? 0 : $lightness;

        return $this->withLightness($lightness);
    }

    /**
     * Saturate the color.
     *
     * @param int $pct
     *
     * @return static
     */
    public function saturate($pct)
    {
        $saturation = $this->saturation() + $pct;
        $saturation = $saturation > 100 ? 100 : $saturation;

        return $this->withSaturation($saturation);
    }

    /**
     * Desaturate the color.
     *
     * @param int $pct
     *
     * @return static
     */
    public function desaturate($pct)
    {
        $saturation = $this->saturation() - $pct;
        $saturation = $saturation < 0 ? 0 : $saturation;

        return $this->withSaturation($saturation);
    }

    /**
     * Get the mix between this and the given color.
     *
     * @param HSL $color
     *
     * @return static
     */
    public function mix(HSL $color)
    {
        return new self(...mixHSL(
            $this->hue(),
            $this->saturation(),
            $this->lightness(),
            $color->hue(),
            $color->saturation(),
            $color->lightness()
        ));
    }

    /**
     * Get color in HEX.
     *
     * @return HEX
     */
    public function toHEX()
    {
        return new HEX(RGBtoHEX(...HSLtoRGB(...$this->hsl())));
    }

    /**
     * Get color in RGB.
     *
     * @return RGB
     */
    public function toRGB()
    {
        return new RGB(...HSLtoRGB(...$this->hsl()));
    }

    /**
     * Get color in HSL.
     *
     * @return HSL
     */
    public function toHSL()
    {
        return new self(...$this->hsl());
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
                '{hue}',
                '{saturation}',
                '{lightness}',
            ],
            [
                $this->hue(),
                $this->saturation(),
                $this->lightness(),
            ],
            $this->template
        );
    }

    /**
     * @param int $value
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
     * @param int $value
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
