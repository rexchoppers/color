<?php

namespace Color;

interface Type
{
    /**
     * Get the key for this type, used to access the type from the color object.
     *
     * @return string
     */
    public static function key();

    /**
     * Cast to string.
     *
     * @return string
     */
    public function __toString();
}
