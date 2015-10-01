<?php

namespace Color\Types;

use function ConvertColor\C256toRGB;
use function ConvertColor\HEXtoRGB;
use function ConvertColor\RGBtoHEX;
use function ConvertColor\RGBtoHSL;
use Color\Color;
use Color\Exceptions\InvalidArgument;

class C256 implements Color
{
    /**
     * @var int (0-255)
     */
    private $code;

    /**
     * @var string
     */
    private $template = '{code}';

    /**
     * C256 constructor.
     *
     * @param int $code
     * @param null|string $template
     *
     * @throws InvalidArgument
     */
    public function __construct($code = 232, $template = null)
    {
        if ( ! $this->isDecimal($code)) {
            throw new InvalidArgument("Decimal (0-255) value was expected but [{$code}] was given.");
        }

        if ($template) {
            $this->template = $template;
        }

        $this->code = (int) $code;
    }

    /**
     * @return int
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
        return new HEX(RGBtoHEX(...C256toRGB($this->code())));
    }

    /**
     * Get color in RGB.
     *
     * @return RGB
     */
    public function toRGB()
    {
        return new RGB(...C256toRGB($this->code()));
    }

    /**
     * Get color in HSL.
     *
     * @return HSL
     */
    public function toHSL()
    {
        return new HSL(...RGBtoHSL(...C256toRGB($this->code())));
    }

    /**
     * Get color in 256.
     *
     * @return C256
     */
    public function to256()
    {
        return new self($this->code());
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
