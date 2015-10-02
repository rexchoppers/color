<?php

namespace Color\Types;

use Color\Color;
use Color\Exceptions\InvalidArgument;
use function Color\Helpers\HEXtoRGB;
use function Color\Helpers\RGBtoC256;
use function Color\Helpers\RGBtoHSL;

class HEX implements Color
{
    /**
     * @var string (000000-FFFFFF)
     */
    private $code;

    /**
     * @var string
     */
    private $template = '#{code}';

    /**
     * Hex constructor.
     *
     * @param string $code
     * @param null|string $template
     *
     * @throws InvalidArgument
     */
    public function __construct($code = '000000', $template = null)
    {
        if ( ! $this->isHexColor($code)) {
            throw new InvalidArgument("Hex value was expected but [{$code}] was given.");
        }

        if ($template) {
            $this->template = $template;
        }

        $this->code = $this->sanitize($code);
    }

    /**
     * @return string
     */
    public function code()
    {
        return $this->code;
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
        return new static($this->code(), $template);
    }

    /**
     * Get color in HEX.
     *
     * @return HEX
     */
    public function toHEX()
    {
        return new self($this->code());
    }

    /**
     * Get color in RGB.
     *
     * @return RGB
     */
    public function toRGB()
    {
        return new RGB(...HEXtoRGB($this->code()));
    }

    /**
     * Get color in HSL.
     *
     * @return HSL
     */
    public function toHSL()
    {
        return new HSL(...RGBtoHSL(...HEXtoRGB($this->code())));
    }

    /**
     * Get color in 256.
     *
     * @return C256
     */
    public function to256()
    {
        return new C256(RGBtoC256(...HEXtoRGB($this->code())));
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
                '{code}',
            ],
            [
                $this->code(),
            ],
            $this->template
        );
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function isHexColor($value)
    {
        $value = ltrim((string) $value, '#');

        if (ctype_xdigit($value) && (strlen($value) == 6 || strlen($value) == 3)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function sanitize($value)
    {
        $value = (string) $value;
        $value = ltrim($value, '#');
        $value = strtoupper($value);

        if (strlen($value) === 3) {
            $value = $value[0] . $value[0] . $value[1] . $value[1] . $value[2] . $value[2];
        }

        return $value;
    }
}
