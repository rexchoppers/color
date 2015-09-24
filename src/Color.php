<?php

namespace Color;

use Color\Types\HEX;
use Color\Types\HSL;
use Color\Types\RGB;

class Color
{
    private $color;
    private $types;

    public function __construct(Type $color)
    {
        $this->color = $color;

        $this->types = [
            HEX::key() => HEX::class,
            RGB::key() => RGB::class,
            HSL::key() => HSL::class,
        ];

        $this->types[$color::key()] = $color;
    }

    public function __get($type)
    {
        $typeClass = $this->findTypeByKey($type);

        return $typeClass;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    private function findTypeByKey($key)
    {
        if ( ! array_key_exists($key, $this->types)) {
            throw new \Exception("Can't find type with key: {$key}");
        }

        $type = $this->types[$key];

        if ($type instanceof Type) {
            return $type;
        }

        return $this->color->to(new $type);
    }


}
