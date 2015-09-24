<?php

namespace Color\Types;

use Color\Converts;
use Color\Type;
use Color\Exceptions\InvalidArgument;

class HEX implements Type, Converts
{
    /**
     * @var string (000000-FFFFFF)
     */
    private $code;

    /**
     * Get the key for this type, used to access the type from the color object.
     *
     * @return string
     */
    public static function key()
    {
        return 'hex';
    }

    /**
     * Hex constructor.
     *
     * @param string $code
     *
     * @throws InvalidArgument
     */
    public function __construct($code = '000000')
    {
        if ( ! $this->isHexColor($code)) {
            throw new InvalidArgument("Hex value was expected but [{$code}] was given.");
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
     * Get color in HEX.
     *
     * @return HEX
     */
    public function toHEX()
    {
        return clone $this;
    }

    /**
     * Get color in RGB.
     *
     * @return RGB
     */
    public function toRGB()
    {
        $rgb = array_map('hexdec',str_split($this->code(), 2));

        return new RGB(...$rgb);
    }

    /**
     * Get color in HSL.
     *
     * @return HSL
     */
    public function toHSL()
    {
        return new HSL();
    }

    /**
     * Cast to string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) "#{$this->code}";
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
